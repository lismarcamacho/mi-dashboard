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
            'fecha_nacimiento' => 'nullable|date_format:d/m/Y',

        ]);

        // Crea el nuevo estudiante
        $validatedData['estatus_activo'] = $request->has('estatus_activo') ? 1 : 0;
        // Convertir la fecha de 'dd/mm/aaaa' a 'YYYY-MM-DD' para la base de datos
        // CONVERSIÓN DE LA FECHA A FORMATO DE BASE DE DATOS (YYYY-MM-DD)




        try {
            $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $validatedData['fecha_nacimiento']);
            $validatedData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['fecha_nacimiento' => 'El formato de fecha es incorrecto. Por favor, use DD/MM/YYYY.']);
        }




        Estudiante::create($request->all());

        // Redirige con un mensaje de éxito
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
            'fecha_nacimiento' => 'nullable|date_format:d/m/Y',
        ]);

        // Actualiza el estudiante
        $validatedData['estatus_activo'] = $request->has('estatus_activo') ? 1 : 0;
        // Convertir la fecha de 'dd/mm/aaaa' a 'YYYY-MM-DD' para la base de datos
        $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $validatedData['fecha_nacimiento']);
        // Formatea a 'Y-m-d' para la base de datos
        $validatedData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');

        $estudiante->update($request->all());

        // Redirige con un mensaje de éxito
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
