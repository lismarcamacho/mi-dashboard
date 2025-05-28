<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carrera;
use GuzzleHttp\Client;
use Illuminate\Validation\Rules\Can;
//use lluminate\Http\RedirectResponse;

class CarreraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return ("lista de carreras");
        // $carrera = Can::all();
        $carreras = Carrera::all();

        // Or, if you want to paginate the results:
        //$carreras = Carrera::paginate(15); // Show 10 carreras per page

        // Fetch all carreras from the database

        return view('carreras.index', compact('carreras'));
        //return view('carreras.index', ['carreras' => $carreras]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return("Nueva carrera");
        return view('carreras.create');
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        $validacion = $request->validate([

            'codigo_carrera' => 'required|string|unique:Carreras,codigo_carrera|min:5|max:15',
            'nombre_carrera' => 'required|string|unique:Carreras,nombre_carrera|max:105',
            'titulo' => 'required|string|max:105',
            'duracion_x_titulo' => 'required|string|max:75',
            'descripcion' => 'required|string|max:255',

        ]);


        $carrera = new Carrera();
        $carrera->codigo_carrera = $request->input('codigo_carrera'); // Asegúrate de que 'codigo_carrera' esté aquí
        $carrera->nombre_carrera = $request->input('nombre_carrera');
        $carrera->titulo = $request->input('titulo');
        $carrera->duracion_x_titulo = $request->input('duracion_x_titulo');
        $carrera->descripcion = $request->input('descripcion');
        $carrera->save();
        //dd('Guardado intentado');
        //return session()->flash('success', 'Especialidad creada exitosamente');

        //  return back();
        return redirect()->route('carreras.index')->with('success', 'Especialidad creada exitosamente');
        // return $request; 
        /**SE PUEDE DESHABILITAR EL RESTO DEL CODIGO DE ESTE METODO STORE Y 
    SOLO CON ESTE RETURN SABEMOS QUE SE ESTAN PASANDO TODOS LOS CAMPOS*********** */

        // La funcion back retrocede al formulario anterior para enviar la notificacion de registro exitoso
        // return back()->with('message','ok');
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
        $carrera = Carrera::find($id);
        //return $carrera; // comprobando que el registro se obtiene correctamente
        return view('carreras.edit', compact('carrera'));
        //return ($id);  Comprobamos que el id se obtiene correctamente
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //vaariable $cliente accede al modelo Cliente y al metodo find
        $carrera = Carrera::find($id);
        $carrera->codigo_carrera = $request->input('codigo_carrera'); // Asegúrate de que 'codigo_carrera' esté aquí
        $carrera->nombre_carrera = $request->input('nombre_carrera');
        $carrera->titulo = $request->input('titulo');
        $carrera->duracion_x_titulo = $request->input('duracion_x_titulo');
        $carrera->descripcion = $request->input('descripcion');
        $carrera->save();
       // return redirect()->route('carreras.index')->width('success','Actualizado Correctamente');
        //return session()->flash('success', 'Especialidad Actualizada exitosamente');
        return back()->with('success', 'Especialidad Actualizada exitosamente');
        //return 'Actualización Exitosa';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        // ESTE RETURN INDICA QUE EL METODO DESTROY ESTA FUNCIONANDO CORECTAMENTE
        // return ($id);

        $carrera = Carrera::find($id);
        $carrera->delete();
        //return back();

        return redirect()->route('carreras.index')->with('success', 'Especialidad eliminada exitosamente');
    }
}
