<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

// Gestión de los permisos (crear, leer, actualizar, eliminar permisos)
class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()                                    // PASO 3
    {
        //
        $permisos = Permission::all();
        return view('users.permisos', compact('permisos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)                 // PASO 4
    {
        //
        // $permission = Permission::create(['name' => 'edit articles']); // EJEMPLO
        $permission = Permission::create(['name' => $request->input('nombre')]);
        return back()->with('success', 'Permiso guardado exitosamente');
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
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)

    {
        //
        $permission = Permission::find($id);
        $permission->name = $request->input('name');

        $permission->save();
       //
        return back()->with('success', 'Permiso Actualizado exitosamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $permission = Permission::find($id);
        $permission->delete();
        //return back();

        return back()->with('success', 'Permiso eliminado exitosamente');
        


    }
}
