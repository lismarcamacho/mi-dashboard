<?php

namespace App\Http\Controllers;

use App\Models\Programa;
use Illuminate\Http\Request;
use Carbon\Carbon; // validar fecha
use App\Models\Especialidad; 

class ProgramaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // Eager loading para cargar las especialidades asociadas de una vez
        $programas = Programa::with('especialidades')->orderBy('nombre_programa')->get();
        return view('programas.index', compact('programas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // $especialidades = Especialidad::all(); // Obtener todas las especialidades
         $todasEspecialidades = Especialidad::orderBy('nombre_especialidad')->get();
         
        return view('programas.create', compact('todasEspecialidades'));
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
            'fecha_programa' => 'required|date_format:Y-m-d',
            'descripcion' => 'required|string|max:255',
            'especialidades' => 'array', // Array de IDs de especialidades
            'especialidades.*' => 'exists:especialidades,id', // Cada ID debe existir


        ]);




        /*if (!empty($validacion['fecha_programa'])) {
            try {
                $fechaString = trim($validacion['fecha_programa']);
                $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8');

                $fechaPrograma = Carbon::createFromFormat('d/m/Y', $fechaString);
                $validacion['fecha_programa'] = $fechaPrograma->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['fecha_programa' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
            }
        }*/


    
         // Crear un array con los campos rellenables, incluyendo la nueva fecha
        //$data = $request->only('nombre_programa','codigo_programa','fecha_programa', 'descripcion' );

            // 3. Crear el nuevo registro en la base de datos utilizando los datos validados
        $programa = Programa::create($validacion);
         // Asociar las especialidades
    // El método sync() adjunta las especialidades dadas y desadjunta cualquier otra que no esté en el array
        $programa->especialidades()->sync($validacion['especialidades'] ?? []); // Si no hay especialidades, pasa un array vacío


        return redirect()->route('programas.index')->with('success', 'Programa creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Programa $programa) // Route Model Binding
    {
        //    
        // Con el Route Model Binding, Laravel ya cargó el programa.
        // Las especialidades ya se pueden acceder a través de $programa->especialidades
        // gracias a la relación definida en el modelo.
 
        return view('programas.show', compact('programa'));
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Programa $programa) // Route Model Binding
    {
        //
      $todasEspecialidades = Especialidad::orderBy('nombre_especialidad')->get();
        // Obtener los IDs de las especialidades ya asignadas
        $especialidadesAsignadasIds = $programa->especialidades->pluck('id')->toArray();

        return view('programas.edit', compact('programa', 'todasEspecialidades', 'especialidadesAsignadasIds'));
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
            'fecha_programa' => 'required|date_format:Y-m-d',
            'descripcion' => 'required|string|max:255',
            'especialidades' => 'nullable|array', // Las especialidades deben ser un array, porque la relacion es many to many
            'especialidades.*' => 'exists:especialidades,id', // Cada ID en el array debe existir en la tabla especialidades

        ]);

        //$programa = Programa::find($id);

       // Manejo de la fecha
        // La validación ya asegura que 'fecha_programa' no esté vacío y tenga el formato correcto.
       /* try {
            $fechaString = trim($validacion['fecha_programa']);
            $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8'); // Saneamiento de la cadena

            $fechaPrograma = Carbon::createFromFormat('d/m/Y', $fechaString);
            $validacion['fecha_programa'] = $fechaPrograma->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['fecha_programa' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
        }*/

 

        //$programa->save(); // Guardar los cambios en la base de datos
        // Crear un array con los campos a actualizar, incluyendo la nueva fecha
        //$data = $request->only('nombre_programa','codigo_programa', 'fecha_programa','descripcion');

        //$programa->update($data);

        //$programa->especialidades()->sync($request->input('especialidades', []));

            // Actualizar el programa
        $programa->update($validacion);

        // Sincronizar las especialidades
        $programa->especialidades()->sync($validacion['especialidades'] ?? []);
        // Si no hay especialidades, pasa un array vacío


      
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
