<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matricula;
use App\Models\Seccion;
use App\Models\Estudiante;
use App\Models\Programa;
// app/Http/Controllers/MatriculaController.php
use App\Models\Trayecto;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreMatriculaRequest;
use App\Http\Requests\UpdateMatriculaRequest;
use Illuminate\Support\Facades\Log;



class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Inicializa $search al principio para que esté disponible para Log::info y dd si es necesario
        $search = $request->input('search'); // Esto obtendrá el valor de 'search' del query string, o null si no existe.

        // Inicia la consulta del modelo Matricula
        $query = Matricula::query();

        // Carga las relaciones necesarias para mostrar los nombres en la tabla
        // Esto evita el problema de "N+1 query" y carga los datos relacionados de forma eficiente.
        $query->with(['seccion', 'estudiante', 'programa']);

         // --- Depuración: Descomenta estas líneas temporalmente para ver qué recibe el método ---
    
 
 
    // --- Depuración: Descomenta estas líneas temporalmente para ver qué recibe el método ---
        Log::info('searchApi: Término de búsqueda recibido: ' . $search);
    // dd($search); // Esto detendrá la ejecución y mostrará el valor de $search. Eliminar después de depurar.

    // 1. Filtro de búsqueda

        // 1. Filtro de búsqueda
        // Podrías buscar por periodo académico, o por nombre de estudiante/sección si unes las tablas.
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->input('search');
            // Ejemplo de búsqueda: buscar en el periodo_academico de la matrícula
            // O buscar en el nombre del estudiante o sección
            $query->where('periodo_academico', 'like', '%' . $search . '%')
                ->orWhereHas('estudiante', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('apellido', 'like', '%' . $search . '%');
                })
                ->orWhereHas('seccion', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%');
                })
                ->orWhereHas('programa', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%');
                });
        }

        // 2. Ordenamiento
        $sortBy = $request->input('sort_by', 'id'); // Columna por defecto para ordenar
        $sortOrder = $request->input('sort_order', 'asc'); // Orden por defecto (ascendente)

        // Validar que la columna sea permitida para evitar inyección SQL
        // Asegúrate de que estas columnas existan en tu tabla 'matriculas'
        $allowedSorts = ['id', 'periodo_academico', 'fecha_inscripcion', 'seccion_id', 'estudiante_id', 'programa_id', 'created_at'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }
        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'asc';
        }

        // Si el ordenamiento es por una columna de relación, se requiere un 'join' o un ordenamiento más complejo
        // Para simplificar, aquí ordenamos por columnas directas de Matricula.
        // Si quisieras ordenar por el nombre del estudiante, necesitarías un JOIN o usar un paquete como 'spatie/laravel-query-builder'
        $query->orderBy($sortBy, $sortOrder);


        // 3. Paginación
        $matriculas = $query->paginate(10); // Puedes ajustar el número de elementos por página

        // Esto asegura que los parámetros de búsqueda y ordenamiento se mantengan al cambiar de página
        $matriculas->appends($request->query());

        // Pasa las variables a la vista
        //return view('matriculas.index', compact('matriculas', 'sortBy', 'sortOrder'));

        // Cargar la relación 'trayecto' para acceder a sus datos
        $matriculas = Matricula::with(['estudiante', 'programa', 'seccion', 'trayecto'])->paginate(10);
        return view('matriculas.index', compact('matriculas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        //$estudiantes = Estudiante::all();
        //$estudiantes = Estudiante::select('id', 'apellidos_nombres', 'cedula')->get();
        $estudiantes = Estudiante::orderBy('id')->paginate(50);
        $programas = Programa::orderBy('nombre_programa')->get();
        $secciones = Seccion::orderBy('nombre')->get(); // Asume que Seccion tiene 'nombre'
        $trayectos = Trayecto::orderBy('nombre_trayecto')->get(); // <-- Obtener los trayectos

        //$programas = Programa::all();
        //$secciones = Seccion::all();
        return view('matriculas.create', compact('secciones', 'estudiantes', 'programas', 'trayectos'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMatriculaRequest $request)
    {


        //NUEVO METODO CONSIDERANDO LA CAPACIDAD MAXIMA DE LA SECCION***************
        // 1. Obtener la ID de la sección de la solicitud de matrícula
        $seccionId = $request->input('seccion_id');

        // 2. Cargar la sección específica junto con el conteo actual de sus matrículas.
        $seccion = Seccion::withCount('matriculas')->find($seccionId);

        // 3. Verificar si la sección existe.
        if (!$seccion) {
            return redirect()->back()->withInput($request->input())->with('error', 'La sección seleccionada para la matrícula no existe.');
        }

        // 4. Implementar la validación de capacidad máxima:
        //    - Se comprueba si la sección tiene una 'capacidad_maxima' definida (no nula y mayor que 0).
        //    - Y si el número de matrículas actuales ('matriculas_count') es igual o mayor a la capacidad máxima.
        if ($seccion->capacidad_maxima > 0 && $seccion->matriculas_count >= $seccion->capacidad_maxima) {
            // ¡Esta es la redirección con el mensaje de error!
            return redirect()->back()->withInput($request->input())->with('error', 'La sección "' . $seccion->nombre . '" ha alcanzado su capacidad máxima de ' . $seccion->capacidad_maxima . ' estudiantes. No se pueden añadir más matrículas.');
        }

        // Si la sección tiene espacio disponible, procede con la creación de la matrícula.
        $validatedData = $request->validated(); // Obtiene solo los datos validados del Form Request

        // ** Recupera la instancia del estudiante. **
        // Puedes recuperar el estudiante de nuevo aquí si necesitas sus atributos completos,
        // o pasarla desde el Request si la preparaste allí.
        $estudiante = Estudiante::find($validatedData['estudiante_id']);

        //Matricula::create($validatedData); // Crea la matrícula

              // 1. Crea la nueva matrícula
        $matricula = Matricula::create([
            'estudiante_id' => $validatedData['estudiante_id'],
            'periodo_academico' => $validatedData['periodo_academico'],
            'programa_id' => $validatedData['programa_id'],
            'trayecto_id' => $validatedData['trayecto_id'],
            'seccion_id' => $validatedData['seccion_id'],
            'condicion_inscripcion' => $validatedData['condicion_inscripcion'],
            'condicion_cohorte' => $validatedData['condicion_cohorte'],
            'fecha_inscripcion' => $validatedData['fecha_inscripcion'],
        ]);

            // 2. Actualiza la cohorte_actual y estado_estudiante del estudiante
        // basado en la 'condicion_inscripcion'.
        if (in_array($validatedData['condicion_inscripcion'], ['REINGRESO', 'PROSECUCION', 'EQUIVALENCIA', 'NUEVO INGRESO'])) {
            // Define el período actual de forma consistente (ej. "2024-II")
            // Puedes tomarlo del $validatedData['periodo_academico'] si el formulario lo envía con el formato completo
            // O generarlo si es el período en que se realiza la matrícula
            $currentYearPeriod = $validatedData['periodo_academico']; // Usar el periodo del formulario

            $estudiante->estado_estudiante = 'Activo';
            $estudiante->cohorte_actual = $currentYearPeriod;
            $estudiante->save();

            // 3. Si tienes una tabla historial_estados_estudiante, añade un registro aquí
            // (Asegúrate de importar el modelo HistorialEstadoEstudiante)
            // if (class_exists(HistorialEstadoEstudiante::class)) {
            //     HistorialEstadoEstudiante::create([
            //         'estudiante_id' => $estudiante->id,
            //         'estado' => 'Activo',
            //         'fecha_cambio' => now(),
            //         'motivo' => 'Inscripción por ' . $validatedData['condicion_inscripcion'],
            //         'periodo_academico' => $currentYearPeriod, // Agrega el período aquí también
            //     ]);
            // }
        }

        return redirect()->route('admin.matriculas.index')->with('success', 'Matrícula creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    
    public function show(Matricula $matricula)
    {
        // Carga solo las relaciones directas que necesitas para mostrar
        // la información de esta matrícula específica en la vista matriculas.show.
        // Las relaciones 'estudiante', 'programa', 'seccion' y 'trayecto'
        // son esenciales para mostrar los detalles del panel izquierdo.
        $matricula->load(['estudiante', 'programa', 'seccion', 'trayecto']);

        // Ya no necesitamos cargar $seccion de nuevo con todas sus matrículas anidadas,
        // porque esa lista de estudiantes por sección ahora reside en secciones.show.
        // La variable $seccion ya está disponible a través de $matricula->seccion
        // si la necesitas para mostrar el nombre de la sección en la vista de matrícula.
        $seccion = $matricula->seccion; // Se mantiene por si la vista lo necesita directamente

        return view('matriculas.show', compact('matricula', 'seccion'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Matricula $matricula)
    {
        $estudiantes = Estudiante::all();
        $programas = Programa::all();
        $secciones = Seccion::all();
        $trayectos = Trayecto::all();

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'programas', 'secciones', 'trayectos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatriculaRequest $request, Matricula $matricula)
    {
        //



        // 3. Crear el nuevo registro en la base de datos utilizando los datos validados
        $validatedData = $request->validated(); // Obtiene solo los datos validados

        //$matricula->update($validatedData);

        $estudiante = Estudiante::find($validatedData['estudiante_id']);

        $matricula->update([
            'estudiante_id' => $validatedData['estudiante_id'],
            'periodo_academico' => $validatedData['periodo_academico'],
            'programa_id' => $validatedData['programa_id'],
            'trayecto_id' => $validatedData['trayecto_id'],
            'seccion_id' => $validatedData['seccion_id'],
            'condicion_inscripcion' => $validatedData['condicion_inscripcion'],
            'condicion_cohorte' => $validatedData['condicion_cohorte'],
            'fecha_inscripcion' => $validatedData['fecha_inscripcion'],
        ]);

        if (in_array($validatedData['condicion_cohorte'], ['REINGRESO', 'PROSECUCION', 'EQUIVALENCIA','NORMAL', 'INICIAL'])) {
            $currentYearPeriod = $validatedData['periodo_academico'];
            $estudiante->estado_estudiante = 'Activo';
            $estudiante->cohorte_actual = $currentYearPeriod;
            $estudiante->save();

            // HistorialEstadoEstudiante (si existe)
            // if (class_exists(HistorialEstadoEstudiante::class)) {
            //     HistorialEstadoEstudiante::create([
            //         'estudiante_id' => $estudiante->id,
            //         'estado' => 'Activo',
            //         'fecha_cambio' => now(),
            //         'motivo' => 'Actualización de matrícula por ' . $validatedData['condicion_inscripcion'],
            //         'periodo_academico' => $currentYearPeriod,
            //     ]);
            // }
        }

        return redirect()->route('matriculas.index')->with('success', 'Matricula creada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Matricula $matricula)
    {
        $matricula->delete();
        return redirect()->route('matriculas.index')->with('success', 'Matrícula eliminada exitosamente.');
    }
}
