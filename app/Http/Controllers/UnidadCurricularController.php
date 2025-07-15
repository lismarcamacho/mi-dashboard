<?php

namespace App\Http\Controllers;
use App\Models\UnidadCurricular; // Asegúrate de importar tu modelo

use Illuminate\Http\Request;

class UnidadCurricularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $unidadesCurriculares = UnidadCurricular::all();
        return view('unidades_curriculares.index', compact('unidadesCurriculares'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
         return view('unidades_curriculares.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            $validacion = $request->validate([

            'codigo' => 'required|string|max:70|unique:unidades_curriculares,codigo',
            'nombre' => 'required|string|max:255',
            'creditos' => 'required|numeric',
            'horas_semanales' => 'required|numeric',
            'horas_trabajo_asistidas' => 'required|numeric',
            'horas_trabajo_independiente' => 'required|numeric',
            'horas_trabajo_estudiantil' => 'required|numeric',
            'eje' => 'required|string|max:255',
            'descripcion' => 'string|max:255',
            'trayecto_id' => 'nullable|exists:trayectos,id'

 
        ]);


        $unidadCurricular = new UnidadCurricular();
        $unidadCurricular->codigo = $request->input('codigo');
        $unidadCurricular->nombre = $request->input('nombre');
        $unidadCurricular->creditos = $request->input('creditos');
        $unidadCurricular->horas_semanales = $request->input('horas_semanales');
        $unidadCurricular->horas_trabajo_asistidas = $request->input('horas_trabajo_asistidas');
        $unidadCurricular->horas_trabajo_independiente = $request->input('horas_trabajo_independiente');
        $unidadCurricular->horas_trabajo_estudiantil = $request->input('horas_trabajo_estudiantil');
        $unidadCurricular->eje = $request->input('eje');
        $unidadCurricular->descripcion = $request->input('descripcion');
        $unidadCurricular->save();
        //dd('Guardado intentado');
        //return session()->flash('success', 'Especialidad creada exitosamente');

        //  return back();
        return redirect()->route('unidades-curriculares.index')->with('success', 'La Unidad Curricular ha sido creada exitosamente');

    }

    /**
     * Display the specified resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(UnidadCurricular $unidadCurricular)
    {
        // La vista también debe estar bien referenciada
        return view('unidades_curriculares.show', compact('unidadCurricular'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $unidadCurricular = UnidadCurricular::find($id);
        return view('unidades_curriculares.edit', compact('unidadCurricular'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //

        $validacion = $request->validate([

            'nombre' => 'required|string|max:255',
            'creditos' => 'required|numeric',
            'horas_semanales' => 'required|numeric',
            'horas_trabajo_asistidas' => 'required|numeric',
            'horas_trabajo_independiente' => 'required|numeric',
            'eje' => 'required|string|max:255',
            'descripcion' => 'string|max:255',
 
        ]);
        $unidadCurricular = UnidadCurricular::find($id);
        $unidadCurricular->codigo = $request->input('codigo');
        $unidadCurricular->nombre = $request->input('nombre');
        $unidadCurricular->creditos = $request->input('creditos');
        $unidadCurricular->horas_semanales = $request->input('horas_semanales');
        $unidadCurricular->horas_trabajo_asistidas = $request->input('horas_trabajo_asistidas');
        $unidadCurricular->horas_trabajo_independiente = $request->input('horas_trabajo_independiente');
        $unidadCurricular->horas_trabajo_estudiantil = $request->input('horas_trabajo_estudiantil');
        $unidadCurricular->eje = $request->input('eje');
        $unidadCurricular->descripcion = $request->input('descripcion');
        $unidadCurricular->save();
       //
        return back()->with('success', 'Unidad Curricular Actualizada exitosamente');
        //return 'Actualización Exitosa';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        
        $unidadCurricular = UnidadCurricular::find($id);
        $unidadCurricular->delete();
        //return back();

        return redirect()->route('unidades-curriculares.index')->with('success', 'Unidad Curricular eliminada exitosamente');

    }
}
