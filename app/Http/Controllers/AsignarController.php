<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

// Gestión de la asignación de roles a los usuarios.

class AsignarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        //dd('Estoy aquí antes de la vista'); // Agrega esta línea
        $users = User::with('roles')->paginate(10); // Carga las relaciones de roles con cada usuario
        return view('users.listUser', compact('users'));
        //return view('users.prueba', compact('users'));
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
    public function store(Request $request)
    {
        //
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
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        // dd($user);
        // return view('users.userRole',compact('user','roles'));
        return view('users.userRole')->with(['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,name', // Asegura que los roles existan
        ]);
        $user->syncRoles($request->input('roles', [])); // Asigna los roles seleccionados (elimina los anteriores)
        return redirect()->route('asignar.index')->with('success', 'Roles del usuario actualizados correctamente.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
