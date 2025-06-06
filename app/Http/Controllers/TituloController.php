<?php

namespace App\Http\Controllers;


use App\Models\Titulo; // Importa tu modelo Titulo
use App\Models\Especialidad; // ¡Importa el modelo Especialidad para el dropdown!
use Illuminate\Http\Request; // Necesario para manejar las peticiones HTTP
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // <-- Añade esta línea

class TituloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //$titulos = Titulo::all();
        // Opcional: Para ver una lista de títulos (con sus especialidades)
        $titulos = Titulo::with('especialidad')->paginate(15); // Carga los títulos con sus especialidades
        return view('titulos.index', compact('titulos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Obtener todas las especialidades para el dropdown del formulario
        //$especialidades = Especialidad::all();
        //$titulos = Titulo::all();
        // Retornar la vista con las especialidades
        //dd($especialidades);
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();
        return view('titulos.create', compact('especialidades'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validacion = $request->validate([
            'nombre' => 'required|string|unique:Titulos,nombre|max:105',
            'duracion' => 'required|string|max:105',
            'especialidad_id' => 'required|string|exists:especialidades,id|max:105',


        ]);


        

        // 1. Obtener la Especialidad completa basada en el ID del formulario
        $especialidad = Especialidad::find($validacion['especialidad_id']);

        // 2. Crear una nueva instancia de Titulo
        $titulo = new Titulo();
        $titulo->nombre = $validacion['nombre'];
        $titulo->duracion = $validacion['duracion'];
        // ... asignar otros campos directamente si no quieres usar fill()

        // 3. Asignar la especialidad usando el método de relación
        $titulo->especialidad()->associate($especialidad);

        // 4. Guardar el título (esto automáticamente guardará el especialidad_id)
        $titulo->save();
        return redirect()->route('titulos.index')->with('success', 'Título creado exitosamente.');


        //  return back();
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
        $titulo = Titulo::find($id);
        $especialidades = Especialidad::orderBy('nombre_especialidad')->get();
       
        return view('titulos.edit', compact('titulo','especialidades'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $titulo = Titulo::find($id);
        $titulo->nombre = $request->input('nombre');
        $titulo->duracion = $request->input('duracion');
       
        $titulo->save();
        //
        return back()->with('success', 'Titulo Actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $titulo = Titulo::find($id);
        $titulo->delete();
        //return back();

        return redirect()->route('titulos.index')->with('success', 'Titulo eliminado exitosamente');
    }
}
