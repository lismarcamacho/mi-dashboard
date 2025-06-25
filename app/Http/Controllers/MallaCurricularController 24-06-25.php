<?php

namespace App\Http\Controllers;

use App\Models\Especialidad;
use App\Models\MallaCurricular;
use App\Models\Programa;
use App\Models\Trayecto;
use App\Models\UnidadCurricular;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
// No directamente usado para 'unique' en esta versión, pero bueno tenerlo:
// use Illuminate\Validation\Rule;

class MallaCurricularController extends Controller
{
    /**
     * Muestra una lista de los recursos.
     * @return \Illuminate\View\View
     */
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
                'creditos_en_malla' => "required|numeric|min:0|max:50",
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

    /**
     * Muestra el recurso especificado.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function show(MallaCurricular $mallaCurricular): View
    {
        $mallaCurricular->load(['especialidad', 'programa', 'unidadesCurriculares.trayecto', 'trayectos']);
        return view('mallas-curriculares.show', compact('mallaCurricular'));
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function edit(MallaCurricular $mallaCurricular): View
    {
        $especialidades = Especialidad::all();
        $trayectos = Trayecto::all();
        $programas = Programa::all(); // Asegúrate de que esta línea esté aquí y el modelo Programa importado

        $mallaCurricular->load('trayectos'); // Cargar los trayectos ya asociados

        return view('mallas-curriculares.edit', compact('mallaCurricular', 'especialidades', 'trayectos', 'programas'));
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, MallaCurricular $mallaCurricular): RedirectResponse
    {
        Log::info('Inicio del método update: Intentando actualizar Malla Curricular.', ['malla_id' => $mallaCurricular->id, 'request_data' => $request->all()]);
        $currentYear = date('Y');
        try {
            $validatedData = $request->validate([
                // La regla unique permite el mismo nombre para el registro actual
                'nombre' => 'required|string|max:255|unique:mallas_curriculares,nombre,' . $mallaCurricular->id,
                'id_especialidad' => 'required|exists:especialidades,id',
                'id_programa' => 'required|exists:programas,id',
                'duracion_en_malla' => 'required|string|max:50',
                'fase_malla' => 'nullable|string|max:20',
                'tipo_uc_en_malla' => 'required|string|max:50',
                'anio_de_vigencia_de_entrada_malla' => 'required|integer|min:1900|max:' . ($currentYear + 5),
                'creditos_en_malla' => 'required|integer|min:0',
                'anio_salida_vigencia' => 'nullable|integer|min:1900|max:' . ($currentYear + 10),
                'trayectos_seleccionados' => 'array',
                'trayectos_seleccionados.*' => 'exists:trayectos,id',
            ]);

            $mallaCurricular->fill($validatedData);

            $especialidad = Especialidad::find($validatedData['id_especialidad']);
            if ($especialidad) {
                $mallaCurricular->especialidad()->associate($especialidad);
            } else {
                Log::error('Especialidad no encontrada al asociar en update.', ['id_especialidad' => $validatedData['id_especialidad']]);
                throw new \Exception('Especialidad no encontrada al actualizar.');
            }

            $programa = Programa::find($validatedData['id_programa']);
            if ($programa) {
                $mallaCurricular->programa()->associate($programa);
            } else {
                Log::error('Programa no encontrado al asociar en update.', ['id_programa' => $validatedData['id_programa']]);
                throw new \Exception('Programa no encontrado al actualizar.');
            }

            $mallaCurricular->save();

            if (!empty($validatedData['trayectos_seleccionados'])) {
                $mallaCurricular->trayectos()->sync($validatedData['trayectos_seleccionados']);
            } else {
                $mallaCurricular->trayectos()->detach(); // O sync([]) si siempre quieres una matriz vacía
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
     * Adjunta una Unidad Curricular a una Malla Curricular.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function attachUnidadCurricular(Request $request, MallaCurricular $mallaCurricular): RedirectResponse
    {
        $request->validate([
            'unidad_curricular_id' => ['required', 'exists:unidades_curriculares,id'],
            'trayecto_id' => ['required', 'exists:trayectos,id'],
        ]);

        $unidadCurricular = UnidadCurricular::find($request->input('unidad_curricular_id'));
        $trayectoId = $request->input('trayecto_id');

        if (!$unidadCurricular) {
            return redirect()->back()->with('error', 'Unidad Curricular no encontrada.');
        }

        $minimoAprobatorio = 12;
        if (str_contains(mb_strtolower($unidadCurricular->nombre), 'proyecto')) {
            $minimoAprobatorio = 16;
        }

        try {
            // Adjuntar la unidad curricular a la malla con los datos pivote
            $mallaCurricular->unidadesCurriculares()->attach($unidadCurricular->id, [
                'trayecto_id' => $trayectoId,
                'minimo_aprobatorio' => $minimoAprobatorio
            ]);

            return redirect()->back()->with('success', 'Unidad Curricular adjuntada a la malla con éxito.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Manejar error de duplicado (código SQLSTATE 23000 es para violación de integridad, ej. clave única)
            if ($e->getCode() === '23000') {
                 return redirect()->back()->with('error', 'Esta Unidad Curricular ya está asignada a este Trayecto en esta Malla.');
            }
            return redirect()->back()->with('error', 'Error al adjuntar la Unidad Curricular: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error inesperado: ' . $e->getMessage());
        }
    }

    /**
     * Desvincula una Unidad Curricular de una Malla Curricular.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @param  \App\Models\UnidadCurricular  $unidadCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function detachUnidadCurricular(MallaCurricular $mallaCurricular, UnidadCurricular $unidadCurricular): RedirectResponse
    {
        try {
            $mallaCurricular->unidadesCurriculares()->detach($unidadCurricular->id);
            return redirect()->back()->with('success', 'Unidad Curricular desvinculada con éxito.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al desvincular la Unidad Curricular: ' . $e->getMessage());
        }
    }

    /**
     * Elimina un recurso de malla curricular de la base de datos.
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(MallaCurricular $mallaCurricular): RedirectResponse
    {
        $mallaCurricular->delete();
        return redirect()->route('mallas-curriculares.index')
            ->with('success', 'Entrada de malla curricular eliminada exitosamente.');
    }

    /**
     * Muestra el formulario para gestionar/añadir Unidades Curriculares a una Malla existente (Paso 2).
     * @param  \App\Models\MallaCurricular  $mallaCurricular
     * @return \Illuminate\View\View
     */
    public function manageUnidadesCurriculares(MallaCurricular $mallaCurricular): View
    {
        $mallaCurricular->load(['unidadesCurriculares.trayecto']);

        $unidadesCurricularesDisponibles = UnidadCurricular::all();
        $trayectosDisponibles = Trayecto::all();

        return view('mallas-curriculares.manage_unidades_curriculares', compact(
            'mallaCurricular',
            'unidadesCurricularesDisponibles',
            'trayectosDisponibles'
        ));
    }
}