<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use Carbon\Carbon; // ¡Añade esta línea!
use App\Models\Especialidad; 

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

            'nombre_programa' => 'required|string|unique:programas,nombre_programa|max:105',
            'codigo_programa' => 'required|string|unique:programas,codigo_programa|max:105',
            'fecha_programa' => 'required|date_format:d/m/Y',
            'descripcion' => 'required|string|max:255',

        ]);




        if (!empty($validacion['fecha_programa'])) {
            try {
                $fechaString = trim($validacion['fecha_programa']);
                $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8');

                $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $fechaString);
                $validacion['fecha_programa'] = $fechaNacimiento->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['fecha_programa' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
            }
        }


        // 3. Crear el nuevo registro en la base de datos utilizando los datos validados
        Programa::create($validacion);

        return redirect()->route('programas.index')->with('success', 'Programa creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Programa $programa)
    {
        //    */
 
        return view('programas.show', compact('programa'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Programa $programa)
    {
        //
      
        return view('programas.edit', compact('programa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  Programa $programa)

    {
        //

        $validacion = $request->validate([

            'nombre_programa' => 'required|string|max:105|unique:programas,nombre_programa,' . $programa->id,
            'codigo_programa' => 'required|string|max:105|unique:programas,codigo_programa,' . $programa->id,
            'fecha_programa' => 'required|date_format:d/m/Y',
            'descripcion' => 'required|string|max:255'

        ]);

        //$programa = Programa::find($id);

       // Manejo de la fecha
        // La validación ya asegura que 'fecha_programa' no esté vacío y tenga el formato correcto.
        try {
            $fechaString = trim($validacion['fecha_programa']);
            $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8'); // Saneamiento de la cadena

            $fechaPrograma = Carbon::createFromFormat('d/m/Y', $fechaString);
            $validacion['fecha_programa'] = $fechaPrograma->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['fecha_programa' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
        }

 

        //$programa->save(); // Guardar los cambios en la base de datos


         $programa->update($validacion);
        return redirect()->route('programas.index')->with('success', 'Programa actualizado exitosamente.');
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
