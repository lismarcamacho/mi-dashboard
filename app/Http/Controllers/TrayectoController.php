<?php

namespace App\Http\Controllers;
use App\Models\Trayecto; // Importa tu modelo Titulo
use App\Models\Especialidad; // ¡Importa el modelo Especialidad para el dropdown!
use Illuminate\Http\Request;

class TrayectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trayectos = Trayecto::all();
        return view('trayectos.index', compact('trayectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();
        return view('trayectos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
        'nombre_trayecto' => 'required|string|max:255|unique:trayectos,nombre_trayecto',
        'descripcion' => 'nullable|string',
        'especialidad_id' => 'required|exists:especialidades,id', // Asegura que la especialidad exista
    ]);
       
        // Trayecto::create($validacion);
        $trayecto = new Trayecto();
        $trayecto->nombre_trayecto = $request->input('nombre_trayecto');
        $trayecto->descripcion = $request->input('descripcion');
        // ... asignar otros campos directamente si no quieres usar fill()
        // 1. Obtener la Especialidad completa basada en el ID del formulario
        $especialidad = Especialidad::find($validacion['especialidad_id']);
        // 3. Asignar la especialidad usando el método de relación
        $trayecto->especialidad()->associate($especialidad);
        $trayecto->save();

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
    public function edit(string $id)
    {
        //
         $trayecto = Trayecto::find($id);
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();

        return view('trayectos.edit', compact('trayecto','especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trayecto = Trayecto::find($id);
        $trayecto->nombre_trayecto= $request->input('nombre_trayecto');
        $trayecto->descripcion = $request->input('descripcion');
        $trayecto->save();
       //
        return back()->with('success', 'Trayecto Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $trayecto= Trayecto::find($id);
        $trayecto->delete();
        //return back();

        return redirect()->route('trayectos.index')->with('success', 'Titulo eliminado exitosamente');
    }
}
