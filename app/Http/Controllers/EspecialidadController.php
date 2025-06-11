<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;
use App\Models\Programa;
use GuzzleHttp\Client;
use Illuminate\Validation\Rules\Can;
//use lluminate\Http\RedirectResponse;


// Gestion de especialidades (crear, leer, actualizar, eliminar carreras)
class EspecialidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return ("lista de carreras");

        $especialidades = Especialidad::all();
        //$especialidades = Especialidad::paginate(15);

        $especialidades = Especialidad::with('titulos')->get();

        // Or, if you want to paginate the results:
        // $carreras = Carrera::paginate(15); // Show 10 carreras per page

        // Fetch all carreras from the database

        return view('especialidades.index', compact('especialidades'));
        //return view('carreras.index', ['carreras' => $carreras]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return("Nueva carrera");
        $programas = Programa::all();
        return view('especialidades.create');
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        $validacion = $request->validate([

            'codigo_especialidad' => 'required|string|unique:Especialidades,codigo_especialidad|min:5|max:15',
            'nombre_especialidad' => 'required|string|unique:Especialidades,nombre_especialidad|max:105',
            'duracion' => 'required|string|max:75',
            'descripcion' => 'required|string|max:255',

        ]);


        $especialidad = new Especialidad();
        $especialidad->codigo_especialidad = $request->input('codigo_especialidad'); // Asegúrate de que 'codigo_carrera' esté aquí
        $especialidad->nombre_especialidad = $request->input('nombre_especialidad');
        //$especialidad->titulo = $request->input('titulo');
        // $especialidad->duracion_x_titulo = $request->input('duracion_x_titulo');
        $especialidad->duracion = $request->input('duracion');
        $especialidad->descripcion = $request->input('descripcion');
        $especialidad->save();
        //dd('Guardado intentado');
        //return session()->flash('success', 'Especialidad creada exitosamente');

        //  return back();
        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada exitosamente');
        // return $request; 
        /**SE PUEDE DESHABILITAR EL RESTO DEL CODIGO DE ESTE METODO STORE Y 
    SOLO CON ESTE RETURN SABEMOS QUE SE ESTAN PASANDO TODOS LOS CAMPOS*********** */

        // La funcion back retrocede al formulario anterior para enviar la notificacion de registro exitoso
        // return back()->with('message','ok');
    }




    /**
     * Display the specified resource.
     */
    public function show(Especialidad $especialidad)
    {

// Carga la especialidad y sus mallas curriculares (asumiendo una relación hasMany en Especialidad)
    //$especialidad->load(['titulos','mallasCurriculares.unidadCurricular', 'mallasCurriculares.trayecto']);
    $especialidad->load('titulos');

    // Necesitarías una relación en Especialidad.php:
    // public function mallasCurriculares() { return $this->hasMany(MallaCurricular::class, 'id_especialidad', 'id'); }
        //$especialidad->load('titulos', 'mallasCurriculares');
    // === Lógica para obtener la Malla Vigente (como lo hicimos antes) ===
    $mallasVigentesPorEspecialidad = null;
    $latestYear = $especialidad->mallasCurriculares()->max('año_de_vigencia_de_entrada_malla');

    if ($latestYear) {
        $mallasVigentesPorEspecialidad = $especialidad->mallasCurriculares()
                                                     ->where('año_de_vigencia_de_entrada_malla', $latestYear)
                                                     ->with(['unidadCurricular', 'trayecto']) // ¡Importante! Precargar estas relaciones
                                                     ->orderBy('id_trayecto')
                                                     ->orderBy('fase_malla')
                                                     ->get();
    }
        return view('especialidades.show', compact('especialidad', 'mallasVigentesPorEspecialidad'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $especialidad = Especialidad::find($id);
        //return $carrera; // comprobando que el registro se obtiene correctamente
        return view('especialidades.edit', compact('especialidad'));
        //return ($id);  Comprobamos que el id se obtiene correctamente
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //vaariable $cliente accede al modelo Cliente y al metodo find
        $especialidad = Especialidad::find($id);
        $especialidad->codigo_especialidad = $request->input('codigo_especialidad'); // Asegúrate de que 'codigo_carrera' esté aquí
        $especialidad->nombre_especialidad = $request->input('nombre_especialidad');
        // $especialidad->titulo = $request->input('titulo');
        // $especialidad->duracion_x_titulo = $request->input('duracion_x_titulo');
        $especialidad->duracion = $request->input('duracion');
        $especialidad->descripcion = $request->input('descripcion');
        $especialidad->save();
        // return redirect()->route('carreras.index')->width('success','Actualizado Correctamente');
        //
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

        $especialidad = Especialidad::find($id);
        $especialidad->delete();
        //return back();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada exitosamente');
    }
}
