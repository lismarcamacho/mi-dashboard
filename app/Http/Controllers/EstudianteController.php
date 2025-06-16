<?php

namespace App\Http\Controllers;

use App\Models\Estudiante;
use Illuminate\Http\Request;
use Carbon\Carbon; // ¡Añade esta línea!

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
            'telefono' => 'nullable|string|max:15', // Telefono puede ser null
            'sede' => 'required|nullable|string|max:100',
            'municipio' => 'required|nullable|string|max:100',
            'parroquia' => 'required|nullable|string|max:100',
            'estatus_activo' => 'boolean', // Será 0 o 1
            'fecha_nacimiento' => 'required|date_format:d/m/Y'

        ]);

        //dd($validatedData['fecha_nacimiento'], gettype($validatedData['fecha_nacimiento']));

        // Crea el nuevo estudiante
        $validatedData['estatus_activo'] = $request->has('estatus_activo') ? 1 : 0;
        // Convertir la fecha de 'dd/mm/aaaa' a 'YYYY-MM-DD' para la base de datos
        // CONVERSIÓN DE LA FECHA A FORMATO DE BASE DE DATOS (YYYY-MM-DD)
 // CONVERSIÓN DE LA FECHA A FORMATO YYYY-MM-DD para la base de datos
        if (!empty($validatedData['fecha_nacimiento'])) {
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
        }

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
            'telefono' => 'nullable|string|max:15',
            'sede' => 'required|nullable|string|max:100',
            'municipio' => 'required|nullable|string|max:100',
            'parroquia' => 'required|nullable|string|max:100',
            'estatus_activo' => 'boolean',
            'fecha_nacimiento' => 'required|date_format:d/m/Y'
        ]);

        //dd($validatedData['fecha_nacimiento'], gettype($validatedData['fecha_nacimiento']));


        if (!empty($validatedData['fecha_nacimiento'])) {
            try {
                $fechaString = trim($validatedData['fecha_nacimiento']);
                $fechaString = mb_convert_encoding($fechaString, 'UTF-8', 'UTF-8');

                $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $fechaString);
                $validatedData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
            } catch (\Exception $e) {
                return back()->withInput()->withErrors(['fecha_nacimiento' => 'Error de formato de fecha. Mensaje: ' . $e->getMessage() . '. Asegúrese de usar DD/MM/YYYY.']);
            }
        }

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
}
