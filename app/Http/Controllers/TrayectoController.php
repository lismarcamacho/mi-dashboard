<?php

namespace App\Http\Controllers;
use App\Models\Trayecto; // Importa tu modelo Titulo
//use App\Models\Especialidad; // ¡Importa el modelo Especialidad para el dropdown!
use Illuminate\Http\Request;

class TrayectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trayectos = Trayecto::all();

        /* NECESITO TENER CARGADA LA ESPECIALIDAD ASOCIADA A CADA TRAYECTO EN EL INDICE PARA 
        QUE EL INDICE GENERAL ME MUESTRE LA ESPECIALIDAD ASOCIADA CUANDO SE GUARDE*/
        //$trayectos = Trayecto::with('especialidad')->get(); 
        
        return view('trayectos.index', compact('trayectos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //$especialidades = Especialidad::orderBy('nombre_especialidad')->get();
       // return view('trayectos.create', compact('especialidades'));
       return view('trayectos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validacion = $request->validate([
        'numero_orden' => 'required|integer|max:25',
        'nombre_trayecto' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ]);
       
        // Trayecto::create($validacion);
        $trayecto = new Trayecto();
        $trayecto->numero_orden = $request->input('numero_orden');
        $trayecto->nombre_trayecto = $request->input('nombre_trayecto');
        $trayecto->descripcion = $request->input('descripcion');
        // ... asignar otros campos directamente si no quieres usar fill()
        // 1. Obtener la Especialidad completa basada en el ID del formulario
        // 3. Asignar la especialidad usando el método de relación
        
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

        //return view('trayectos.edit', compact('trayecto','especialidades'));
        return view('trayectos.edit', compact('trayecto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $trayecto = Trayecto::find($id);
        $trayecto->numero_orden = $request->input('numero_orden');
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
