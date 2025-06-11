<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\MallaCurricular;
use App\Models\Trayecto;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Añade esta línea

class MallaCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $mallasCurriculares = MallaCurricular::all();
        // Carga las mallas curriculares con sus relaciones para mostrar nombres en lugar de solo IDs
        $mallasCurriculares = MallaCurricular::with(['especialidad', 'unidadCurricular', 'trayecto'])->get();
        return view('mallas-curriculares.index', compact('mallasCurriculares'));

       // Cargar todas las especialidades con sus mallas,
        // y para cada malla, cargar sus trayectos,
        // y para cada trayecto, cargar sus unidades curriculares.

        //$especialidades = Especialidad::with([
        //    'mallasCurriculares' => function ($query) {
        //        $query->orderBy('anio_de_vigencia_de_entrada_malla', 'desc'); // Ordenar mallas por año de entrada, por ejemplo
        //    },
        //    'mallasCurriculares.trayectos' => function ($query) {
        //        $query->orderBy('nombre_trayecto'); // Ordenar trayectos por nombre
        //    },
        //    'mallasCurriculares.trayectos.unidadesCurriculares' => function ($query) {
        //        $query->orderBy('nombre'); // Ordenar unidades curriculares por nombre
        //    }
       // ])->get();

       // return view('mallas-curriculares.index', compact('especialidades'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Carga los datos necesarios para los selectores del formulario
        $especialidades = Especialidad::all();
        $unidadesCurriculares = UnidadCurricular::all();
        $trayectos = Trayecto::orderBy('numero_orden')->get(); // Ordenar trayectos por el nuevo campo numero_orden
        // Obtener los IDs de las unidades curriculares que son "materia proyecto"
        // Asumiendo que tienes una columna 'es_proyecto' (booleana) en tu tabla 'unidades_curriculares'
        // Es crucial que esta columna exista en tu migración y modelo de UnidadCurricular
        $materiaProyectoIds = UnidadCurricular::where('es_proyecto', true)->pluck('id')->toArray();
        return view('mallas-curriculares.create', compact('especialidades', 'unidadesCurriculares', 'trayectos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Reglas de validación para los datos de la malla curricular
        // Obtener el año actual dinámicamente
        //dd($request->all());
        $currentYear = date('Y');
        $validatedData = $request->validate([
            'id_especialidad' => 'required|exists:especialidades,id',
            'id_unidad_curricular' => 'required|exists:unidades_curriculares,id',
            'id_trayecto' => 'required|exists:trayectos,id',
            'minimo_aprobatorio' => 'required|numeric|min:0|max:20', // Asumiendo escala de 0-20
            'duracion_en_malla' => 'required|string|max:50',
            'fase_malla' => 'nullable|string|max:20',
            'tipo_uc_en_malla' => 'required|string|max:50',
            'anio_de_vigencia_de_entrada_malla' => "nullable|integer|min:1900|max:{$currentYear}",
            'anio_salida_vigencia' => "nullable|integer|min:1900|max:{$currentYear}",
            'creditos_en_malla'=>"required|numeric|min:0|max:20",
        ]);

        // Crear una nueva entrada de malla curricular


        try {
            // Opcional: Re-ajustar mínimo aprobatorio en backend si es crítico
            $unidadCurricular = UnidadCurricular::find($validatedData['id_unidad_curricular']);
            if ($unidadCurricular && str_starts_with(strtoupper($unidadCurricular->nombre), 'PROYECTO')) {
                $validatedData['minimo_aprobatorio'] = 16;
            } else {
                $validatedData['minimo_aprobatorio'] = 12;
            }

            // Instanciar el modelo
            $mallaCurricular = new MallaCurricular();
            // Asignar los valores a las propiedades del modelo
            $mallaCurricular->minimo_aprobatorio = $validatedData['minimo_aprobatorio'];
            $mallaCurricular->duracion_en_malla = $validatedData['duracion_en_malla'];
            $mallaCurricular->fase_malla = $validatedData['fase_malla'];
            $mallaCurricular->tipo_uc_en_malla = $validatedData['tipo_uc_en_malla'];
            $mallaCurricular->anio_de_vigencia_de_entrada_malla = $validatedData['anio_de_vigencia_de_entrada_malla'];
            $mallaCurricular->creditos_en_malla = $validatedData['creditos_en_malla'];
            $mallaCurricular->anio_salida_vigencia = $validatedData['anio_salida_vigencia'];

            // === ASIGNAR RELACIONES USANDO associate() ===
            // 1. Especialidad
            $especialidad = Especialidad::find($validatedData['id_especialidad']);
            if ($especialidad) {
                $mallaCurricular->especialidad()->associate($especialidad);
            } else {
                // Esto no debería pasar si la validación exists:especialidades,id funciona correctamente
                // pero es buena práctica manejarlo
                throw new \Exception('Especialidad no encontrada al asociar.');
            }

            // 2. Unidad Curricular
            // Ya la hemos obtenido arriba para la lógica del mínimo aprobatorio
             $unidadCurricular = UnidadCurricular::find($validatedData['id_unidad_curricular']);
            if ($unidadCurricular) {
                $mallaCurricular->unidadCurricular()->associate($unidadCurricular);
            } else {
                throw new \Exception('Unidad Curricular no encontrada al asociar.');
            }

            // 3. Trayecto
            $trayecto = Trayecto::find($validatedData['id_trayecto']);
            if ($trayecto) {
                $mallaCurricular->trayecto()->associate($trayecto);
            } else {
                throw new \Exception('Trayecto no encontrado al asociar.');
            }


            $mallaCurricular->save();
            // MallaCurricular::create($request->all()); // Una sola línea de código hace el trabajo de asignar todos los campos y guardarlos (si usas create()). NOTA TODOS LOS CAMPOS ACA EN VALIDACION DEBEN ESTAR TAMBIEN EN FILLABLE DENTRO DEL MODELO MallaCurricular
            return redirect()->route('mallas-curriculares.index')
                ->with('success', 'Malla Curricular creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear Malla Curricular: ' . $e->getMessage(), ['exception' => $e]);
            return back()->withInput()->with('error', 'Hubo un problema al crear la Malla Curricular. Inténtalo de nuevo.');
        }
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de una entrada de malla curricular específica.
     */
    public function show(MallaCurricular $mallaCurricular)
    {
        // Carga la entrada de malla con sus relaciones
        //$mallaCurricular = MallaCurricular::findOrFail($id);

        $mallaCurricular->load(['especialidad', 'unidadCurricular', 'trayecto']);
        return view('mallas-curriculares.show', compact('mallaCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     * Muestra el formulario para editar una entrada de malla curricular existente.
     */
    public function edit(string $id)
    {
        // Carga los datos necesarios para los selectores del formulario de edición
        
        $mallaCurricular = MallaCurricular::findOrFail($id);
    
        $especialidades = Especialidad::all();
        $unidadesCurriculares = UnidadCurricular::all();
        $trayectos = Trayecto::orderBy('numero_orden')->get();

        return view('mallas-curriculares.edit', compact('mallaCurricular', 'especialidades', 'unidadesCurriculares', 'trayectos'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza una entrada de malla curricular existente en la base de datos.
     */
    public function update(Request $request, MallaCurricular $mallaCurricular)
    {
        // Reglas de validación para la actualización
        $request->validate([
            'id_especialidad' => 'required|exists:especialidades,id',
            'id_unidad_curricular' => 'required|exists:unidades_curriculares,id',
            'id_trayecto' => 'required|exists:trayectos,id',
            'minimo_aprobatorio' => 'required|numeric|min:0|max:20',
            'duracion_en_malla' => 'required|string|max:50',
            'fase_malla' => 'nullable|string|max:20',
            'tipo_uc_en_malla' => 'required|string|max:50',
            'anio_de_vigencia_de_entrada_malla' => 'required|nullable|integer|min:1900|max:' . (date('Y') + 10),
            'anio_salida_vigencia' => 'nullable|integer|min:1900|max:' . (date('Y') + 10),
            'creditos_en_malla' => 'nullable|integer|min:1',
        ]);

        // Actualizar la entrada de malla curricular
        $mallaCurricular->update($request->all());

        return redirect()->route('mallas-curriculares.index')
            ->with('success', 'Entrada de malla curricular actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     * Elimina una entrada de malla curricular de la base de datos.
     */
    public function destroy(MallaCurricular $mallaCurricular)
    {
        $mallaCurricular->delete();
        return redirect()->route('mallas-curriculares.index')
            ->with('success', 'Entrada de malla curricular eliminada exitosamente.');
    }
}
