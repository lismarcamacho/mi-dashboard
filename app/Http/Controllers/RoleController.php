<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Contracts\Role as ContractsRole;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role as ModelsRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//  Gestión de los roles (crear, leer, actualizar, eliminar roles)

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
        //$role = Role::find($id);
        $role = Role::with('permissions')->findOrFail($id); //  cargando el rol antes de que la utilices en la vista
        //return $role;  COMPROBAMOS QUE EFECTIVAMENTE EL METODO EDIT ESTA OBTENIENDO DATOS DE LA BASE DE DATOS
        $permisos = Permission::all();
        // dd($role);
        return view('users.rolePermiso', compact('role','permisos'));
        // en campact se pasan las variables
    }


    /**
     * Update the specified resource in storage.
     * 
     * Se actualiza el NOMBRE del ROL
     */

       // $carrera = Carrera::find($id);
        //return $carrera; // comprobando que el registro se obtiene correctamente
       // return view('carreras.edit', compact('carrera'));


  /*  public function update(Request $request, string $id)
    {
        //
        $role = Role::find($id);
        $role->name= $request->input('name');
        $role->save();
       //
        return back()->with('success', 'Nombre del Rol Actualizado exitosamente');
        //return 'Actualización Exitosa';
    }*/


// aqui se asignan permisos a un rol
    public function update(Request $request, Role $role) 
    {
        //


        
        $permissions = $request->input('permissions', []); // Obtiene un array de los IDs de los permisos seleccionados

        // El método sync() sincroniza las relaciones muchos a muchos.
        // Eliminará los permisos existentes del rol y adjuntará los nuevos.
        $role->permissions()->sync($permissions);

        return redirect()->route('roles.index')->with('success', 'Permisos del rol actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage. SE ELIMINA EL ROL
     */
    public function destroy(string $id)
    {
        //
        
        $role = Role::find($id);
        $role->delete();
        //return back();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente');
        
    }
}
