<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\MallaCurricular;
use App\Models\Trayecto;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Añade esta línea
use Illuminate\Validation\Rule; 
use Illuminate\Http\JsonResponse; // Para el tipo de retorno
/* RULE:  Esto es para poder editar una malla curricular y
| que no de problemas por el nombre ya que el nombre es unico 
| y para no romper la regla la unicidad se permite editar una
|malla cuando no se cambia el nombre*/


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
        // $trayectos = Trayecto::all(); // <-- Esta línea es la clave para obtener los trayectos

        $mallasCurriculares = MallaCurricular::with(['especialidad', 'trayectos'])->get();
        // $mallasCurriculares = MallaCurricular::with(['especialidad'])->get();

        return view('mallas-curriculares.index', compact('mallasCurriculares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pasa una nueva instancia vacía de MallaCurricular
        $mallaCurricular = new MallaCurricular();
        $especialidades = Especialidad::all();
        $trayectos = Trayecto::all(); // Esta variable es para la vista 'create'

        return view('mallas-curriculares.create', compact('mallaCurricular', 'especialidades', 'trayectos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Reglas de validación para los datos de la malla curricular
        Log::info('Inicio del metodo store, intentando guardar Malla Curricular.');
        // dd($request->all()); // <-- PARA HACER DEPURACION : ¡PARA AQUÍ y mira si 'nombre' está presente y con valor!

        $currentYear = date('Y');
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255',
                'id_especialidad' => 'required|exists:especialidades,id',
                'duracion_en_malla' => 'nullable|string|max:50',
                'fase_malla' => 'nullable|string|max:20',
                'tipo_uc_en_malla' => 'required|string|max:50',
                'anio_de_vigencia_de_entrada_malla' => "nullable|integer|min:1900|max:{$currentYear}",
                'anio_salida_vigencia' => "nullable|integer|min:1900|max:{$currentYear}",
                'creditos_en_malla' => "required|numeric|min:0|max:50",
                'trayectos_seleccionados' => 'required|array', // Debe ser un array de IDs de trayectos
                'trayectos_seleccionados.*' => 'exists:trayectos,id', // Cada ID en el array debe existir en la tabla trayectos
            ]);
            Log::info('Validación de datos exitosa.', ['validatedData' => $validatedData]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al crear Malla Curricular: ' . $e->getMessage(), ['errors' => $e->errors()]);
            // dd($e->errors()); // Descomenta esto para ver los errores de validación en el navegador
            return back()->withInput()->withErrors($e->errors())->with('error', 'Por favor, corrige los errores del formulario.');
        }

        // Para depuración:
        // dd($validatedData); // Revisa los datos validados antes de continuar

        // 2. Crear una nueva instancia del modelo MallaCurricular
        $mallaCurricular = new MallaCurricular();

        // 3. Asignar cada campo de forma explícita
        $mallaCurricular->duracion_en_malla = $validatedData['duracion_en_malla'];
        $mallaCurricular->nombre = $validatedData['nombre'];
        $mallaCurricular->fase_malla = $validatedData['fase_malla'];
        $mallaCurricular->tipo_uc_en_malla = $validatedData['tipo_uc_en_malla'];
        $mallaCurricular->anio_de_vigencia_de_entrada_malla = $validatedData['anio_de_vigencia_de_entrada_malla'];
        $mallaCurricular->creditos_en_malla = $validatedData['creditos_en_malla'];
        $mallaCurricular->anio_salida_vigencia = $validatedData['anio_salida_vigencia'];
        Log::info('Campos de MallaCurricular asignados.', ['mallaCurricular_data' => $mallaCurricular->toArray()]);
        // ***** LÍNEA DE DEPURACIÓN CLAVE: Aquí vemos el modelo final antes de guardar *****
        //dd('Modelo MallaCurricular justo antes de SAVE:', $mallaCurricular->toArray());

        try {
            $especialidad = Especialidad::find($validatedData['id_especialidad']);
            if ($especialidad) {
                $mallaCurricular->especialidad()->associate($especialidad);
                Log::info('Especialidad asociada.', ['especialidad_id' => $especialidad->id]);
            } else {
                Log::error('Especialidad no encontrada al asociar (esto no debería pasar si la validación funciona).', ['id_especialidad' => $validatedData['id_especialidad']]);
                throw new \Exception('Especialidad no encontrada al asociar.');
            }

            Log::info('Datos de MallaCurricular justo antes de SAVE:', [
                'nombre_a_guardar' => $mallaCurricular->nombre ?? 'N/A', // Muestra el nombre
                'todos_los_atributos' => $mallaCurricular->getAttributes(), // Muestra todos los atributos del modelo
            ]);

            Log::info('Intentando guardar MallaCurricular en la base de datos.');
            $mallaCurricular->save(); // Aquí se guarda la MallaCurricular y obtiene su ID
            Log::info('MallaCurricular guardada exitosamente.', ['mallaCurricular_id' => $mallaCurricular->id]);

            // **ASOCIAR LOS TRAYECTOS A LA MALLA (DESPUÉS DE GUARDAR LA MALLA)**
            if (!empty($validatedData['trayectos_seleccionados'])) {
                $mallaCurricular->trayectos()->sync($validatedData['trayectos_seleccionados']);
                Log::info('Trayectos sincronizados.', ['trayectos_sincronizados' => $validatedData['trayectos_seleccionados']]);
            } else {
                $mallaCurricular->trayectos()->sync([]);
                Log::info('No se seleccionaron trayectos o se desvincularon todos.');
            }

            Log::info('Redirigiendo a index con éxito.');
            return redirect()->route('mallas-curriculares.index')
                ->with('success', 'Malla Curricular creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error general al crear Malla Curricular: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString(), 'request_data' => $request->all()]);
            // dd($e->getMessage()); // Descomenta para ver el mensaje de error directamente en el navegador
            return back()->withInput()->with('error', 'Hubo un problema al crear la Malla Curricular. Inténtalo de nuevo.');
        }
    }

    /**
     * Display the specified resource.
     * Muestra los detalles de una entrada de malla curricular específica.
     */
    public function show(MallaCurricular $mallaCurricular)
    {

        $mallaCurricular->load(['especialidad']);

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
        // $unidadesCurriculares = UnidadCurricular::all();
        // $trayectos = Trayecto::orderBy('numero_orden')->get();
        $trayectos = Trayecto::all(); // Asegúrate de pasar también los trayectos

        // return view('mallas-curriculares.edit', compact('mallaCurricular', 'especialidades', 'unidadesCurriculares', 'trayectos'));
        return view('mallas-curriculares.edit', compact('mallaCurricular', 'especialidades', 'trayectos'));
    }

    /**
     * Update the specified resource in storage.
     * Actualiza una entrada de malla curricular existente en la base de datos.
     */
    public function update(Request $request, MallaCurricular $mallaCurricular)
    {
        // Reglas de validación para la actualización
        Log::info('Inicio del método update: Intentando actualizar Malla Curricular.', ['malla_id' => $mallaCurricular->id, 'request_data' => $request->all()]);
        //dd("ID de la Malla actual: " . $mallaCurricular->id, "Nombre recibido: " . $request->nombre, "Regla unique esperada: " . 'unique:mallas_curriculares,nombre,' . $mallaCurricular->id . ',id');
 // ***** LÍNEA DE DEPURACIÓN CLAVE *****
         //dd("ID de la Malla actual: " . $mallaCurricular->id, "Nombre recibido: " . $request->nombre, "Regla Unique Objeto:", $uniqueRule);
        $currentYear = date('Y');
        try {
            $validatedData = $request->validate([
           
            'nombre' => 'required|string|max:255|unique:mallas_curriculares,nombre,' . $mallaCurricular->id,

            'id_especialidad' => 'required|exists:especialidades,id',
                'duracion_en_malla' => 'required|string|max:50',
                'fase_malla' => 'nullable|string|max:20',
                'tipo_uc_en_malla' => 'required|string|max:50',
                'anio_de_vigencia_de_entrada_malla' => 'required|integer|min:1900|max:' . ($currentYear + 5),
                'creditos_en_malla' => 'required|integer|min:0',
                'anio_salida_vigencia' => 'nullable|integer|min:1900|max:' . ($currentYear + 10),
                // 'minimo_aprobatorio' => 'nullable|numeric|min:0|max:20', // Si lo tienes descomentado, ajusta 'nullable'
                'trayectos_seleccionados' => 'array', // 'array' es suficiente, 'required' depende si es obligatorio seleccionar al menos uno
                'trayectos_seleccionados.*' => 'exists:trayectos,id',
            ]);

            // Asigna los datos validados al modelo $mallaCurricular (que ya fue inyectado)
            $mallaCurricular->fill($validatedData);

            // La asociación de especialidad puede ir aquí antes de save()
            $especialidad = Especialidad::find($validatedData['id_especialidad']);
            if ($especialidad) {
                $mallaCurricular->especialidad()->associate($especialidad);
            } else {
                Log::error('Especialidad no encontrada al asociar en update.', ['id_especialidad' => $validatedData['id_especialidad']]);
                throw new \Exception('Especialidad no encontrada al actualizar.');
            }

            $mallaCurricular->save(); // Guarda los cambios en la base de datos para la malla existente

            // Sincronizar trayectos (esto necesita el ID de la malla, que ya existe)
            if (!empty($validatedData['trayectos_seleccionados'])) {
                $mallaCurricular->trayectos()->sync($validatedData['trayectos_seleccionados']);
            } else {
                $mallaCurricular->trayectos()->detach(); // Si no se seleccionan trayectos, se desvinculan todos
            }

            Log::info('Malla Curricular actualizada exitosamente.', ['mallaCurricular_id' => $mallaCurricular->id]);
            return redirect()->route('mallas-curriculares.index')
                ->with('success', 'Malla Curricular actualizada exitosamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al actualizar Malla Curricular: ' . $e->getMessage(), ['errors' => $e->errors(), 'request_data' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Por favor, corrige los errores del formulario de actualización.');
        } catch (\Exception $e) {
            Log::error('Error general al actualizar Malla Curricular: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString(), 'request_data' => $request->all()]);
            return redirect()->back()->withInput()->with('error', 'Hubo un problema al actualizar la Malla Curricular: ' . $e->getMessage());
        }
    }



    /**
     * Adjunta una Unidad Curricular a una Malla Curricular,
     * determinando el mínimo aprobatorio según el tipo de UC.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\JsonResponse
     */
    public function attachUnidadCurricularToMalla(Request $request, MallaCurricular $mallaCurricular): JsonResponse
    {
        // Valida los datos de entrada
        $request->validate([
            'unidad_curricular_id' => ['required', 'exists:unidades_curriculares,id'],
            'trayecto_id' => ['nullable', 'exists:trayectos,id'], // 'nullable' si no siempre es necesario
        ]);

        $unidadCurricularId = $request->input('unidad_curricular_id');
        $trayectoId = $request->input('trayecto_id');

        $unidadCurricular = UnidadCurricular::find($unidadCurricularId);

        // Ya validamos con 'exists', pero esta es una capa extra o para lógica compleja
        if (!$unidadCurricular) {
            return response()->json(['error' => 'Unidad Curricular no encontrada.'], 404);
        }

        // Lógica para determinar el minimo_aprobatorio
        // Asegúrate de que esta lógica es la que deseas: si el nombre CONTIENE 'proyecto'
        $minimoAprobatorio = 12; // Valor por defecto
        if (str_contains(mb_strtolower($unidadCurricular->nombre), 'proyecto')) {
            $minimoAprobatorio = 16;
        }

        try {
            // Adjuntar la unidad curricular a la malla con los datos de la pivote
            // El método attach evita duplicados por defecto si se usa la PK de la tabla pivote como unique key
            // O puedes usar sync para sincronizar un array de IDs con la pivote
            $mallaCurricular->unidadesCurriculares()->attach($unidadCurricularId, [
                'trayecto_id' => $trayectoId,
                'minimo_aprobatorio' => $minimoAprobatorio
            ]);

            return response()->json(['message' => 'Unidad Curricular adjuntada a la malla con éxito.'], 200);

        } catch (\Exception $e) {
            // Manejo de errores, por ejemplo, si la entrada ya existe (debido al unique constraint en la pivote)
            // o cualquier otro error de base de datos.
            return response()->json(['error' => 'Error al adjuntar la Unidad Curricular: ' . $e->getMessage()], 500);
        }
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
