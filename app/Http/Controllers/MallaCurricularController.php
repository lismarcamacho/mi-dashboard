<?php

namespace App\Http\Controllers;

use App\Models\Especialidad; // Mantener si otras funciones lo usan
use App\Models\MallaCurricular;
use App\Models\Programa;     // Mantener si otras funciones lo usan
use App\Models\Trayecto;    // Mantener si otras funciones lo usan
use App\Models\UnidadCurricular; // Mantener si otras funciones lo usan
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule; // Asegúrate de que esta importación esté presente para Rule::in()


class MallaCurricularController extends Controller
{
    // ... (Mantén index, create, store, edit, update, destroy EXACTAMENTE como los tienes ahora, funcionando) ...
    //      attachUnidadCurricular, detachUnidadCurricular, manageUnidadesCurriculares
    // son los metodos para asignar desasignar y adminitrar las unidades curriculares en la malla
    //    


    public function index(): View
    {

        // Carga las relaciones necesarias para la tabla (especialidad, programa, trayectos)
        $mallasCurriculares = MallaCurricular::with(['especialidad', 'programa', 'trayectos'])->get();
        return view('mallas-curriculares.index', compact('mallasCurriculares'));
    }
    /**
     * Muestra el formulario para crear un nuevo recurso.
     * @return \Illuminate\View\View
     */
    public function create(): View
    {
        $mallaCurricular = new MallaCurricular();
        $especialidades = Especialidad::all();
        $trayectos = Trayecto::all();
        $programas = Programa::all(); // Asegúrate de pasar los programas aquí
        return view('mallas-curriculares.create', compact('mallaCurricular', 'especialidades', 'trayectos', 'programas'));
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        Log::info('Inicio del metodo store: Intentando guardar Malla Curricular.');
        $currentYear = date('Y');
        try {
            $validatedData = $request->validate([
                'nombre' => 'required|string|max:255|unique:mallas_curriculares,nombre',
                'id_especialidad' => 'required|exists:especialidades,id',
                'id_programa' => 'required|exists:programas,id',
                'duracion_en_malla' => 'nullable|string|max:50',
                'fase_malla' => 'nullable|string|max:20',
                'tipo_uc_en_malla' => 'required|string|max:50',
                'anio_de_vigencia_de_entrada_malla' => "nullable|integer|min:1900|max:" . ($currentYear + 5),
                'anio_salida_vigencia' => "nullable|integer|min:1900|max:" . ($currentYear + 10),
                'creditos_en_malla' => "required|numeric|min:0|max:176", 
                // 176 es la cantidad de creditos totales desde el trayecto I AL IV,
                // NO VEO POR NINGUN LADO LA CANTIDAD DE CREDITOS DE LAS MATERIAS DEL PIU...
                'trayectos_seleccionados' => 'array',
                'trayectos_seleccionados.*' => 'exists:trayectos,id',
            ]);
            Log::info('Validación de datos exitosa.', ['validatedData' => $validatedData]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación al crear Malla Curricular: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return back()->withInput()->withErrors($e->errors())->with('error', 'Por favor, corrige los errores del formulario.');
        }

        try {
            $mallaCurricular = new MallaCurricular();
            $mallaCurricular->fill($validatedData);

            $especialidad = Especialidad::find($validatedData['id_especialidad']);
            if ($especialidad) {
                $mallaCurricular->especialidad()->associate($especialidad);
            } else {
                Log::error('Especialidad no encontrada al asociar (esto no debería pasar si la validación funciona).', ['id_especialidad' => $validatedData['id_especialidad']]);
                throw new \Exception('Especialidad no encontrada al asociar.');
            }

            $programa = Programa::find($validatedData['id_programa']);
            if ($programa) {
                $mallaCurricular->programa()->associate($programa);
            } else {
                Log::error('Programa no encontrado al asociar (esto no debería pasar si la validación funciona).', ['id_programa' => $validatedData['id_programa']]);
                throw new \Exception('Programa no encontrado al asociar.');
            }

            $mallaCurricular->save();

            if (!empty($validatedData['trayectos_seleccionados'])) {
                $mallaCurricular->trayectos()->sync($validatedData['trayectos_seleccionados']);
            } else {
                $mallaCurricular->trayectos()->sync([]); // Si no hay trayectos seleccionados, desvincula todos los existentes
            }

            return redirect()->route('mallas-curriculares.index')
                ->with('success', 'Malla Curricular creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error general al crear Malla Curricular: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString(), 'request_data' => $request->all()]);
            return back()->withInput()->with('error', 'Hubo un problema al crear la Malla Curricular. Inténtalo de nuevo.');
        }
    }

    // CAMBIOS 24-06-25

 /**
     * Muestra la información detallada de una Malla Curricular,
     * incluyendo sus unidades curriculares asociadas agrupadas por trayecto y período/fase.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function show(MallaCurricular $mallaCurricular): View
    {
        // Cargar las relaciones necesarias con los pivotes.
        $mallaCurricular->load([
            'especialidad',
            'programa',
            'unidadesCurriculares' => function($query) {
                // Especificamos los campos del pivote que necesitamos cargar
                $query->withPivot('trayecto_id', 'minimo_aprobatorio', 'tipo_uc_en_malla', 'periodo_de_carga', 'numero_de_fase');
            },
            // Aseguramos que la relación trayecto para cada unidad curricular también se cargue
            // Esto es crucial para acceder a $uc->pivot->trayecto->nombre en las vistas
            'unidadesCurriculares.trayecto',
            'trayectos' // Cargar los trayectos asociados directamente a la malla si los necesitas
        ]);

        // Aseguramos que tenemos todos los trayectos disponibles para agrupar en la vista (show y manage),
        // incluso si no tienen unidades curriculares asignadas todavía.
        $allTrayectos = Trayecto::orderBy('id')->get();

        return view('mallas-curriculares.show', compact('mallaCurricular', 'allTrayectos'));
    }

    // CAMBIOS 24-06-25
    /**
     * Muestra el formulario para gestionar/añadir Unidades Curriculares a una Malla existente.
     * Pasa las opciones de tipo de unidad curricular, períodos y fases.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function manageUnidadesCurriculares(MallaCurricular $mallaCurricular): View
    {
        // Cargar las unidades curriculares ya asignadas a esta malla, con sus datos pivote y el trayecto asociado.
        $mallaCurricular->load(['unidadesCurriculares' => function($query) {
            $query->withPivot('trayecto_id', 'minimo_aprobatorio', 'tipo_uc_en_malla', 'periodo_de_carga', 'numero_de_fase');
        }, 'unidadesCurriculares.trayecto']); // Asegúrate de cargar la relación 'trayecto' también para el pivote


        $unidadesCurricularesDisponibles = UnidadCurricular::orderBy('nombre')->get(); // Ordenar para mejor UX
        $trayectosDisponibles = Trayecto::orderBy('id')->get(); // Ordenar por ID para consistencia

        // Opciones para el campo 'Tipo en el Pensum' (para el pivote)
        $tiposUcDisponibles = [
            'Obligatoria',
            'Electiva',
            'Servicio Comunitario',
            'Proyecto',
            'Practicas profesionales',
        ];

        // Opciones para 'Período de Carga' (para el pivote)
        $periodosDeCargaDisponibles = [
            'Anual',
            'Fase',
            'Semestral',
            'Trimestral',
        ];

        // Opciones para 'Número de Fase' (para el pivote)
        // Puedes ajustar este rango según tus necesidades reales
        $numerosDeFaseDisponibles = collect(range(1, 10))->mapWithKeys(fn($item) => [$item => $item]);

        return view('mallas-curriculares.manage_unidades_curriculares', compact(
            'mallaCurricular',
            'unidadesCurricularesDisponibles',
            'trayectosDisponibles',
            'tiposUcDisponibles',
            'periodosDeCargaDisponibles',
            'numerosDeFaseDisponibles'
        ));
    }

    // CAMBIOS 24-06-25
    /**
     * Adjunta una Unidad Curricular a una Malla Curricular con detalles del pensum.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attachUnidadCurricular(Request $request, MallaCurricular $mallaCurricular): RedirectResponse
    {
        Log::info('Intentando adjuntar unidad curricular', $request->all());

        // Reglas de validación para los nuevos campos en el pivote
        $request->validate([
            'unidad_curricular_id' => ['required', 'exists:unidades_curriculares,id'],
            'trayecto_id' => ['required', 'exists:trayectos,id'],
            'tipo_uc_en_malla_pivot' => ['required', 'string', Rule::in(['Obligatoria', 'Electiva', 'Servicio Comunitario', 'Proyecto', 'Practicas profesionales'])],
            'periodo_de_carga' => ['required', 'string', Rule::in(['Anual', 'Fase', 'Semestral', 'Trimestral'])],
            // 'numero_de_fase' es requerido si el periodo de carga es 'Fase', 'Semestral' o 'Trimestral'
            'numero_de_fase' => ['nullable', 'integer', 'min:1', 'max:10', 'required_if:periodo_de_carga,Fase,Semestral,Trimestral'],
        ]);

        $unidadCurricularId = $request->input('unidad_curricular_id');
        $trayectoId = $request->input('trayecto_id');
        $tipoUcPivot = $request->input('tipo_uc_en_malla_pivot');
        $periodoDeCarga = $request->input('periodo_de_carga');
        $numeroDeFase = $request->input('numero_de_fase');

        // Lógica para determinar el minimo_aprobatorio basada en el nombre de la UC
        $unidadCurricular = UnidadCurricular::find($unidadCurricularId);
        $minimoAprobatorio = 12; // Valor por defecto
        if ($unidadCurricular && str_contains(mb_strtolower($unidadCurricular->nombre), 'proyecto')) {
            $minimoAprobatorio = 16;
        }

        try {
            // Verificar si la combinación Malla-Unidad-Trayecto-Periodo-Fase ya existe
            // Esto previene duplicados en el pensum según tu lógica
            $existingAttachment = $mallaCurricular->unidadesCurriculares()
                                                  ->wherePivot('unidad_curricular_id', $unidadCurricularId)
                                                  ->wherePivot('trayecto_id', $trayectoId)
                                                  ->wherePivot('periodo_de_carga', $periodoDeCarga)
                                                  ->where(function($query) use ($numeroDeFase) {
                                                      if (is_null($numeroDeFase)) {
                                                          $query->whereNull('numero_de_fase');
                                                      } else {
                                                          $query->where('numero_de_fase', $numeroDeFase);
                                                      }
                                                  })
                                                  ->exists();

            if ($existingAttachment) {
                return redirect()->back()->with('error', 'Esta Unidad Curricular ya está asignada a este Trayecto, Período y Fase en esta Malla.');
            }

            // Adjuntar la unidad curricular a la malla con todos los datos del pivote
            $mallaCurricular->unidadesCurriculares()->attach($unidadCurricularId, [
                'trayecto_id' => $trayectoId,
                'minimo_aprobatorio' => $minimoAprobatorio,
                'tipo_uc_en_malla' => $tipoUcPivot,
                'periodo_de_carga' => $periodoDeCarga,
                'numero_de_fase' => $numeroDeFase,
            ]);

            return redirect()->back()->with('success', 'Unidad Curricular adjuntada a la malla con éxito.');

        } catch (\Exception $e) {
            Log::error('Error al adjuntar la Unidad Curricular: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString(), 'request_data' => $request->all()]);
            return redirect()->back()->with('error', 'Error al adjuntar la Unidad Curricular: ' . $e->getMessage());
        }
    }
    // CAMBIOS 24-06-25
    /**
     * Desvincula una Unidad Curricular de una Malla Curricular.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @param  \App\Models\UnidadCurricular  $unidadCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detachUnidadCurricular(MallaCurricular $mallaCurricular, UnidadCurricular $unidadCurricular): RedirectResponse
    {
        try {
            // Aquí puedes necesitar un ajuste si deseas desvincular una unidad específica
            // cuando hay múltiples entradas por el mismo unidad_curricular_id (ej. diferente fase)
            // Por ahora, se desvinculará todas las asociaciones de esa UC a esa Malla.
            $mallaCurricular->unidadesCurriculares()->detach($unidadCurricular->id);
            return redirect()->back()->with('success', 'Unidad Curricular desvinculada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al desvincular la Unidad Curricular: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al desvincular la Unidad Curricular.');
        }
    }



    /**
     * Muestra el formulario para editar el recurso especificado (VERSIÓN MÍNIMA).
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function edit(MallaCurricular $mallaCurricular): View
    {
        // dd($mallaCurricular);
        $especialidades = Especialidad::all();
        $trayectos = Trayecto::all();
        $programas = Programa::all(); // Esta línea es crucial

        $mallaCurricular->load('trayectos'); // Carga los trayectos asociados para que old() e in_array() funcionen

        return view('mallas-curriculares.edit', compact('mallaCurricular', 'especialidades', 'trayectos', 'programas'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento (VERSIÓN MÍNIMA).
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MallaCurricular $mallaCurricular): RedirectResponse
    {
        Log::info('Intentando actualización MINIMA de Malla Curricular.', ['malla_id' => $mallaCurricular->id]);

        try {
            $validatedData = $request->validate([
                // Solo validamos el nombre. La regla unique permite el mismo nombre para el registro actual.
                'nombre' => 'required|string|max:255|unique:mallas_curriculares,nombre,' . $mallaCurricular->id,
            ]);

            $mallaCurricular->update(['nombre' => $validatedData['nombre']]);

            Log::info('Malla Curricular actualizada exitosamente (versión mínima).', ['mallaCurricular_id' => $mallaCurricular->id]);
            return redirect()->route('mallas-curriculares.index')
                ->with('success', 'Malla Curricular actualizada exitosamente (versión mínima).');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Error de validación MINIMA al actualizar Malla Curricular: ' . $e->getMessage(), ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput()->with('error', 'Error de validación en la actualización mínima.');
        } catch (\Exception $e) {
            Log::error('Error general en actualización MINIMA: ' . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
            return redirect()->back()->withInput()->with('error', 'Error inesperado al actualizar (versión mínima): ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $mallaCurricular = MallaCurricular::find($id); // importante para que logre eliminar
        $mallaCurricular->delete();
        return redirect()->route('mallas-curriculares.index')
            ->with('success', 'Entrada de malla curricular eliminada exitosamente.');
    }
}
