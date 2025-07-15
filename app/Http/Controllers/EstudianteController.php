<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Carbon\Carbon; // ¡Añade esta línea!
use Illuminate\Support\Facades\Response; // ¡Asegúrate de importar esto!
use Illuminate\Support\Facades\Log;


class EstudianteController extends Controller
{
    /**
     * Muestra una lista de todos los estudiantes.
     */
    public function index()
    {
        $estudiantes = Estudiante::all();
        return view('estudiantes.index', compact('estudiantes'));
    }

    /**
     * Muestra el formulario para crear un nuevo estudiante.
     */
    public function create()
    {
        return view('estudiantes.create');
    }

    /**
     * Guarda un nuevo estudiante en la base de datos.
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'cedula' => 'required|string|max:20|unique:estudiantes,cedula',
            'apellidos_nombres' => 'required|string|max:255',
            'email' => 'nullable|email|max:100', // Email puede ser null
            'telefono' => 'nullable|string|max:20', // Telefono puede ser null
            'sede' => 'required|nullable|string|max:100',
            'municipio' => 'required|nullable|string|max:100',
            'parroquia' => 'required|nullable|string|max:100',
            //'estatus_activo' => 'boolean', // Será 0 o 1
            'fecha_nacimiento' => 'required|date_format:Y-m-d',

              // --- Nuevos campos de cohorte y estado 25-06-25 ---
              // regla regex para permitir esto: 2024-1 ó 2024-2 en vez de solo el año: 2024
            'cohorte_ingreso' => ['nullable', 'string', 'max:10', 'regex:/^(\d{4}|\d{4}-[1-2])$/'],
            'cohorte_actual' => ['nullable', 'string', 'max:10', 'regex:/^(\d{4}|\d{4}-[1-2])$/'],
            'estado_estudiante' => 'required|string|max:50',
            

        ]);

        //dd($validatedData['fecha_nacimiento'], gettype($validatedData['fecha_nacimiento']));

        // Crea el nuevo estudiante
        //$validatedData['estatus_activo'] = $request->has('estatus_activo') ? 1 : 0;
        // Convertir la fecha de 'dd/mm/aaaa' a 'YYYY-MM-DD' para la base de datos
        // CONVERSIÓN DE LA FECHA A FORMATO DE BASE DE DATOS (YYYY-MM-DD)
 // CONVERSIÓN DE LA FECHA A FORMATO YYYY-MM-DD para la base de datos
       /* if (!empty($validatedData['fecha_nacimiento'])) {
            try {
                // **PASO CLAVE: Limpiar la cadena antes de Carbon::createFromFormat**
                $fechaString = trim($validatedData['fecha_nacimiento']);
                // Asegúrate de que sea utf8 para evitar problemas de codificación
                $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8');

                // Crea un objeto Carbon interpretando la cadena limpia como DD/MM/YYYY
                $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $fechaString);
                // Formatea el objeto Carbon a YYYY-MM-DD para guardar en la DB
                $validatedData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
            } catch (\Exception $e) {
                // Esto debería capturar el "Unexpected character" si persiste.
                return back()->withInput()->withErrors(['fecha_nacimiento' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
            }
        }*/

        Estudiante::create($validatedData);
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante creado exitosamente.');
    }



    /**
     * Muestra los detalles de un estudiante específico.
     */
    public function show(Estudiante $estudiante)
    {
        return view('estudiantes.show', compact('estudiante'));
    }

    /**
     * Muestra el formulario para editar un estudiante existente.
     */
    public function edit(Estudiante $estudiante)
    {
        return view('estudiantes.edit', compact('estudiante'));
    }

    /**
     * Actualiza un estudiante existente en la base de datos.
     */
    public function update(Request $request, Estudiante $estudiante)
    {
        // Valida los datos del formulario (cedula unique ignorando la actual)
        // PERMITE EDITAR EL ESTUDIANTE GRACIAS A :      . $estudiante->id,
        $validatedData = $request->validate([
            'cedula' => 'required|string|max:20|unique:estudiantes,cedula,' . $estudiante->id,
            'apellidos_nombres' => 'required|string|max:255',
            'email' => 'nullable|email|max:100',
            'telefono' => 'nullable|string|max:20',
            'sede' => 'required|nullable|string|max:100',
            'municipio' => 'required|nullable|string|max:100',
            'parroquia' => 'required|nullable|string|max:100',
            //'estatus_activo' => 'boolean',
            'fecha_nacimiento' => 'required|date_format:Y-m-d',
            // cambiar a nullable si toca
              // --- Nuevos campos de cohorte y estado ---
              // regla regex para permitir esto: 2024-1 ó 2024-2 en vez de solo el año: 2024
             'cohorte_ingreso' => ['nullable', 'string', 'max:10', 'regex:/^(\d{4}|\d{4}-[1-2])$/'],
            'cohorte_actual' => ['nullable', 'string', 'max:10', 'regex:/^(\d{4}|\d{4}-[1-2])$/'],
            'estado_estudiante' => 'required|string|max:50',
        ]);

        //dd($validatedData['fecha_nacimiento'], gettype($validatedData['fecha_nacimiento']));


        /*if (!empty($validatedData['fecha_nacimiento'])) {
            try {
                $fechaString = trim($validatedData['fecha_nacimiento']);
                $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8');

                $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $fechaString);
                $validatedData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['fecha_nacimiento' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
            }
        }*/

        $estudiante->update($validatedData);
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante actualizado exitosamente.');
    }
    

    /**
     * Elimina un estudiante de la base de datos.
     */
    public function destroy(Estudiante $estudiante)
    {
        $estudiante->delete();

        // Redirige con un mensaje de éxito
        return redirect()->route('estudiantes.index')->with('success', 'Estudiante eliminado exitosamente.');
    }
    /**
     * Busca estudiantes para ser usados en un Select2 AJAX.
     * Recibe un término de búsqueda y devuelve los resultados en formato JSON.
     * searchApi que devuelve los datos en el formato JSON esperado por Select2.
     *  hay que verificar que no haya errores.
     */
    public function searchApi(Request $request)
    {
        $search = $request->query('term'); // Select2 envía el término de búsqueda en 'term'

        
        // --- Depuración: Descomenta estas líneas temporalmente para ver qué recibe el método ---
        Log::info('searchApi: Término de búsqueda recibido: ' . $search);
        dd($search); // Esto detendrá la ejecución y mostrará el valor de $search

        $estudiantes = Estudiante::where('cedula', 'LIKE', "%{$search}%")
                                 ->orWhere('apellidos_nombres', 'LIKE', "%{$search}%")
                                 ->limit(10) // Limita los resultados
                                 ->get(['id', 'cedula', 'apellidos_nombres']); // Selecciona solo las columnas necesarias

        $results = [];
        foreach ($estudiantes as $estudiante) {
            $results[] = [
                'id' => $estudiante->id,
                'text' => "{$estudiante->apellidos_nombres} (C.I.: {$estudiante->cedula})",
            ];
        }

        return Response::json(['results' => $results]);
    }

  public function buscar(Request $request)
    {
        // -----------------------------------------------------------
        // PASO 1: VERIFICAR QUÉ TÉRMINO DE BÚSQUEDA RECIBE EL CONTROLADOR
        // -----------------------------------------------------------
        $searchTerm = $request->input('q'); // 'q' es el parámetro que Select2 envía por defecto.
                                            // Si tu JS en Select2.ajax.data lo llama diferente, cámbialo aquí.
       // dd("Término de búsqueda recibido: " . $searchTerm);
        // Cuando pruebes esto, verás una página blanca con el término.
        // Escribe "LUIS" o "185" en el campo y mira qué sale aquí.

        // -----------------------------------------------------------
        // PASO 2: VERIFICAR QUÉ ESTUDIANTES ENCUENTRA LA CONSULTA
        // -----------------------------------------------------------
        $estudiantes = Estudiante::where('cedula', 'like', '%' . $searchTerm . '%')
                                 ->orWhere('apellidos_nombres', 'like', '%' . $searchTerm . '%')
                                 ->limit(10) // Limita el número de resultados para no sobrecargar
                                 ->get();

        dd($estudiantes->toArray());
        // Cuando pruebes esto, verás un array de los objetos Estudiante que se encontraron.
        // Si sale un array vacío '[]', la consulta no está encontrando nada.

        // -----------------------------------------------------------
        // PASO 3: VERIFICAR EL FORMATO FINAL PARA SELECT2
        // -----------------------------------------------------------
        $formattedEstudiantes = $estudiantes->map(function ($estudiante) {
            return [
                'id' => $estudiante->id,
                'text' => $estudiante->cedula . ' - ' . $estudiante->apellidos_nombres . ' ',
            ];
        });

        // dd($formattedEstudiantes->toArray());
        // Cuando pruebes esto, verás el array final con el formato {id: ..., text: ...}.
        // Si este array es correcto, el problema no está en el backend.

        return response()->json($formattedEstudiantes);
    }



}
