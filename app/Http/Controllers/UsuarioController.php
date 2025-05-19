<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
   
          public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

       public function edit(User $user)
    {
        // Lógica para mostrar el formulario de edición del usuario
        return view('users.edit', compact('user')); // Ejemplo de retorno de una vista
    }

    public function store(Request $request)
    {
        // Valida y guarda el usuario
        $user = new User($request->all());
        $user->save();

        return redirect()->route('users.index');
    }

      public function destroy(User $user)
    {
        // Lógica para eliminar el usuario
        $user->delete();

        // Redireccionar o devolver una respuesta
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

}


