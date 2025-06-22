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


class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        // Inicia la consulta del modelo Matricula
        $query = Matricula::query();

        // Carga las relaciones necesarias para mostrar los nombres en la tabla
        // Esto evita el problema de "N+1 query" y carga los datos relacionados de forma eficiente.
        $query->with(['seccion', 'estudiante', 'programa']);

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
        //   
           //dd($request->all()); // Pon esto para ver qué datos llegan

    // Si el Form Request pasa la validación, los datos ya estarán validados
    // y disponibles en $request->validated().
    // Si no pasa, Laravel redirige automáticamente con los errores.

        $validatedData = $request->validated(); // Obtiene solo los datos validados



        // 3. Crear el nuevo registro en la base de datos utilizando los datos validados
        $matricula = Matricula::create($validatedData);

        return redirect()->route('matriculas.index')->with('success', 'Matricula creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Matricula $matricula) // Route Model Binding
    {
        //
        // Cargar la relación 'trayecto' para acceder a sus datos
        $matricula->load('trayecto'); // Carga la relación si no se hizo en el index
        return view('matriculas.show', compact('matricula'));
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

        return view('matriculas.edit', compact('matricula', 'estudiantes', 'programas', 'secciones','trayectos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMatriculaRequest $request, Matricula $matricula)
    {
        //
   


        // 3. Crear el nuevo registro en la base de datos utilizando los datos validados
        $validatedData = $request->validated(); // Obtiene solo los datos validados

        $matricula->update($validatedData);

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
