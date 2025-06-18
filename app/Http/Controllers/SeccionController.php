<?php

namespace App\Http\Controllers;

use App\Models\Seccion; // ¡Importa el modelo Seccion!
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    /**
     * Muestra una lista de todas las secciones.
     * GET /secciones
     */
    public function index()
    {
        $secciones = Seccion::all(); // Obtiene todas las secciones de la base de datos
        return view('secciones.index', compact('secciones')); // Pasa las secciones a la vista
    }

    /**
     * Muestra el formulario para crear una nueva sección.
     * GET /secciones/create
     */
    public function create()
    {
        return view('secciones.create');
    }

    /**
     * Almacena una nueva sección en la base de datos.
     * POST /secciones
     */
    public function store(Request $request)
    {
        // Reglas de validación para los campos de la sección
        $request->validate([
            'nombre' => 'required|string|unique:secciones,nombre|max:255', // Nombre único
            'capacidad_maxima' => 'required|integer|min:0', // Capacidad mínima 0
        ]);

        // Crea una nueva instancia de Sección y guarda los datos validados
        Seccion::create($request->all());

        // Redirecciona a la lista de secciones con un mensaje de éxito
        return redirect()->route('secciones.index')->with('success', 'Sección creada exitosamente.');
    }

    /**
     * Muestra los detalles de una sección específica (opcional para un CRUD básico).
     * GET /secciones/{seccion}
     */
    public function show(Seccion $seccion)
    {
        // Puedes implementar este metodo si necesitas una vista de detalles individual para cada sección

        // CARGA LAS RELACIONES NECESARIAS:
        // Carga la sección y sus matrículas. Dentro de cada matrícula, carga el estudiante y el programa.
        $seccion->load(['matriculas' => function($query) {
            $query->with('estudiante', 'programa');
        }]);
        return view('secciones.show', compact('seccion'));
    }

    /**
     * Muestra el formulario para editar una sección existente.
     * GET /secciones/{seccion}/edit
     */
    public function edit(Seccion $seccion)
    {
        return view('secciones.edit', compact('seccion')); // Pasa la sección a la vista de edición
    }

    /**
     * Actualiza una sección existente en la base de datos.
     * PUT/PATCH /secciones/{seccion}
     */
    public function update(Request $request, Seccion $seccion)
    {
        // Reglas de validación para actualizar la sección
        $request->validate([
            // 'nombre' debe ser único, excluyendo el nombre de la propia sección que estamos actualizando
            'nombre' => 'required|string|unique:secciones,nombre,' . $seccion->id . '|max:255',
            'capacidad_maxima' => 'required|integer|min:0',
        ]);

        // Actualiza la instancia de Sección con los datos validados
        $seccion->update($request->all());

        // Redirecciona a la lista de secciones con un mensaje de éxito
        return redirect()->route('secciones.index')->with('success', 'Sección actualizada exitosamente.');
    }

    /**
     * Elimina una sección de la base de datos.
     * DELETE /secciones/{seccion}
     */
    public function destroy(Seccion $seccion)
    {
        // Implementar lógica de eliminación, asegurándose de manejar matrículas asociadas
        // Como la relación en Matricula tiene onDelete('set null'), sus matrículas no se borrarán.
        $seccion->delete();
        return redirect()->route('secciones.index')->with('success', 'Sección eliminada exitosamente.');
    }
}
