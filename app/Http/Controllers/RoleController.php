<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()                          // PASO 1
    {
    
    $roles = ModelsRole::all();
    return view('users.roles', compact('roles'));

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
    public function store(Request $request)            // PASO 2
    {
        //

        $role = Role::create(['name' => $request->input('nombre')]);
        // en el campo nombre se asignara el valor que viene de request es decir el valor que viene del formulario
        //return back(); retorna al formulario sin dar notificacion
        return back()->with('success', 'Rol guardado exitosamente');
        //return ('hola estoy accediendo al metodo store');
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
        $role = Role::find($id);
        //return $role;  COMPROBAMOS QUE EFECTIVAMENTE EL METODO EDIT ESTA OPTENIENDO DATOS DE LA BASE DE DATOS
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
