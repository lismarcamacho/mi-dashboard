<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $programas = Programa::all();
        return view('programas.index', compact('programas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
          return view('programas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
            $validacion = $request->validate([

            'nombre_programa' => 'required|string|unique:Programas,nombre_programa|max:105',
            'descripcion' => 'required|string|max:255',

        ]);


        $programa = new Programa();
        $programa->nombre_programa = $request->input('nombre_programa');
        $programa->descripcion = $request->input('descripcion');
        $programa->save();
        //dd('Guardado intentado');
        //return session()->flash('success', 'Especialidad creada exitosamente');

        //  return back();
        return redirect()->route('programas.index')->with('success', 'Programa creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $programa = Programa::find($id);
        return view('programas.edit', compact('programa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $programa = Programa::find($id);
        $programa->nombre_programa = $request->input('nombre_programa');
        $programa->descripcion = $request->input('descripcion');
        $programa->save();
       //
        return back()->with('success', 'Programa Actualizado exitosamente');
        //return 'Actualización Exitosa';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //

        $programa = Programa::find($id);
        $programa->delete();
        //return back();

        return redirect()->route('programas.index')->with('success', 'Programa eliminado exitosamente');

    }
}
