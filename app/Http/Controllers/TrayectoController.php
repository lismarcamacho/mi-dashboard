<?php

namespace App\Http\Controllers;

use App\Models\Trayecto;
//use App\Models\Especialidad;
use App\Models\UnidadCurricular;
use App\Models\Programa;
use Illuminate\Validation\Rule; // Importa la clase Rule para validación unique


use Illuminate\Http\Request;

class TrayectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trayectos = Trayecto::all();

        // $trayectos = Trayecto::with('unidadesCurriculares')->get(); 
        // $unidadesCurriculares = UnidadCurricular::all();

        // === OPCIÓN 1: Solo carga la relación 'programa' (si es lo que necesitas en la vista index) ===
        $trayectos = Trayecto::with('programa')->get();

        // === OPCIÓN 2: Si no necesitas cargar ninguna relación para la vista index de trayectos ===
        // $trayectos = Trayecto::all();

        // === OPCIÓN 3: Si necesitas 'programa' y 'matriculas' (si tienes esa relación) ===
        // $trayectos = Trayecto::with('programa', 'matriculas')->get();
        //return view('trayectos.index', compact('trayectos','unidadesCurriculares'));
        return view('trayectos.index', compact('trayectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $programas = Programa::all(); // Obtiene todos los programas

        return view('trayectos.create', compact('programas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numero_orden' => 'required|integer|max:25',
            'nombre_trayecto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'programa_id' => 'required|exists:programas,id', // nuevo 20/06/25 Valida que el ID exista en la tabla 'programas'

        ]);



        Trayecto::create($validatedData); // asignacion masiva , tiene que tener todos los campos en fillable en el modelo trayecto



        return redirect()->route('trayectos.index')->with('success', 'Trayecto creado exitosamente.');
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
    public function edit(Trayecto $trayecto)
    {
        //
        //$trayecto = Trayecto::find($id);
        $programas = Programa::all(); // También necesitas los programas para el select


        //return view('trayectos.edit', compact('trayecto','especialidades'));
        return view('trayectos.edit', compact('trayecto', 'programas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trayecto $trayecto)
    {

        $validatedData = $request->validate([
            'numero_orden' => [
                'required',
                'integer',
                // Rule::unique para que ignore el ID del trayecto que estamos editando
                Rule::unique('trayectos')->ignore($trayecto->id),
            ],
            'nombre_trayecto' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'programa_id' => 'required|exists:programas,id',
        ]);
        //$trayecto = Trayecto::find($id);
        //$trayecto->numero_orden = $request->input('numero_orden');
        //$trayecto->nombre_trayecto = $request->input('nombre_trayecto');
        //$trayecto->descripcion = $request->input('descripcion');
        //$trayecto->save();
        //
        $trayecto->update($validatedData);


        return back()->with('success', 'Trayecto Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trayecto = Trayecto::find($id);
        $trayecto->delete();
        //return back();

        return redirect()->route('trayectos.index')->with('success', 'Trayecto eliminado exitosamente');
    }
}
