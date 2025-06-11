<?php

namespace App\Http\Controllers;

use App\Models\MallaCurricular;
use App\Models\Especialidad;
use App\Models\UnidadCurricular;
use App\Models\Trayecto;
use App\Models\VersionMalla; // Importa el nuevo modelo VersionMalla
use Illuminate\Http\Request;

class MallaCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mallasCurriculares = MallaCurricular::with(['especialidad', 'unidadCurricular', 'trayecto', 'versionMalla'])->get();
        return view('mallas_curriculares.index', compact('mallasCurriculares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = Especialidad::all();
        $unidadesCurriculares = UnidadCurricular::all();
        $trayectos = Trayecto::orderBy('numero_orden')->get();
        $versionesMalla = VersionMalla::all(); // Carga las versiones de malla

        return view('mallas_curriculares.create', compact('especialidades', 'unidadesCurriculares', 'trayectos', 'versionesMalla'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // La validación del año de entrada en vigencia ahora puede ser más relajada,
        // ya que la fecha de vigencia principal está en la versión de malla.
        $request->validate([
            'id_especialidad' => 'required|exists:especialidades,id',
            'id_unidad_curricular' => 'required|exists:unidades_curriculares,id',
            'id_trayecto' => 'required|exists:trayectos,id',
            'id_version_malla' => 'required|exists:versiones_malla,id', // Nueva validación
            'minimo_aprobatorio' => 'required|numeric|min:0|max:20',
            'duracion_en_malla' => 'required|string|max:50',
            'fase_malla' => 'nullable|string|max:20',
            'tipo_uc_en_malla' => 'required|string|max:50',
            // El 'max' se relaja aquí, ya que la versión de malla maneja la vigencia global.
            'año_de_vigencia_de_entrada_malla' => "nullable|integer|min:1900|max:" . (date('Y') + 10), 
            'creditos_en_malla' => 'nullable|integer|min:1',
        ]);

        MallaCurricular::create($request->all());

        return redirect()->route('mallas-curriculares.index')
                         ->with('success', 'Entrada de malla curricular creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MallaCurricular $mallaCurricular)
    {
        $mallaCurricular->load(['especialidad', 'unidadCurricular', 'trayecto', 'versionMalla']);
        return view('mallas_curriculares.show', compact('mallaCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MallaCurricular $mallaCurricular)
    {
        $especialidades = Especialidad::all();
        $unidadesCurriculares = UnidadCurricular::all();
        $trayectos = Trayecto::orderBy('numero_orden')->get();
        //$versionesMalla = VersionMalla::all(); // Carga las versiones de malla

        return view('mallas_curriculares.edit', compact('mallaCurricular', 'especialidades', 'unidadesCurriculares', 'trayectos', 'versionesMalla'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MallaCurricular $mallaCurricular)
    {
        $request->validate([
            'id_especialidad' => 'required|exists:especialidades,id',
            'id_unidad_curricular' => 'required|exists:unidades_curriculares,id',
            'id_trayecto' => 'required|exists:trayectos,id',
            'id_version_malla' => 'required|exists:versiones_malla,id', // Nueva validación
            'minimo_aprobatorio' => 'required|numeric|min:0|max:20',
            'duracion_en_malla' => 'required|string|max:50',
            'fase_malla' => 'nullable|string|max:20',
            'tipo_uc_en_malla' => 'required|string|max:50',
            'año_de_vigencia_de_entrada_malla' => "nullable|integer|min:1900|max:" . (date('Y') + 10), 
            'creditos_en_malla' => 'nullable|integer|min:1',
        ]);

        $mallaCurricular->update($request->all());

        return redirect()->route('mallas-curriculares.index')
                         ->with('success', 'Entrada de malla curricular actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MallaCurricular $mallaCurricular)
    {
        $mallaCurricular->delete();

        return redirect()->route('mallas-curriculares.index')
                         ->with('success', 'Entrada de malla curricular eliminada exitosamente.');
    }
}