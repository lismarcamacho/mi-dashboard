<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Importa la clase Hash
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Support\Facades\Validator; // Para validar los datos
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log; 

class UsuarioController extends Controller
{
   // Obtiene todos los usuarios de la base de datos
    public function index()
    {
        $users = User::all();
        //$users = User::paginate(15); 
        dd($users);
        Log::info('Cargando usuarios para la vista:', ['count' => $users->count(), 'first_user_email' => $users->first() ? $users->first()->email : 'N/A']);
        return view('users.listUser', compact('users')); 
        //return view('users.index', ['users' => $users]);
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



    // ... otros métodos ...



    // ... otros métodos ...



    

    
   // public function cambiarClave(Request $request)
    //{
     //   $request->validate([
     //       'current_password' => 'required|current_password',
     //       'password' => ['required', 'confirmed', Password::min(8)], // Utiliza la regla de contraseña de Laravel
     //   ], [
     //       'current_password.required' => 'La contraseña actual es obligatoria.',
     //       'current_password.current_password' => 'La contraseña actual es incorrecta.',
     //       'password.required' => 'La nueva contraseña es obligatoria.',
     //       'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
     //       'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
     //   ]);

     //   try{

     //   $user = Auth::user();
     //   $user->update([
     //       'password' => Hash::make($request->password),
     //   ]);

     //   return redirect()->route('profile.index')->with('success', 'Contraseña actualizada correctamente.');
     //   }catch (\Exception $e) {
        // Log the error: Log::error('Error al actualizar la contraseña: ' . $e->getMessage());
     //   return redirect()->back()->with('error', 'Hubo un error al actualizar la contraseña. Por favor, inténtalo de nuevo.');
   // }
//}


    public function cambiarClave(Request $request, User $user)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)], // Utiliza la regla de contraseña de Laravel
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'current_password.current_password' => 'La contraseña actual es incorrecta.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.confirmed' => 'La confirmación de la nueva contraseña no coincide.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        ]);

        try{

        $user = Auth::user();
        dd($user);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Contraseña actualizada correctamente.');
        }catch (\Exception $e) {
        // Log the error: Log::error('Error al actualizar la contraseña: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Hubo un error al actualizar la contraseña. Por favor, inténtalo de nuevo.');
    }
    }






      public function destroy(User $user)
    {
        // Lógica para eliminar el usuario
        $user->delete();

        // Redireccionar o devolver una respuesta
        return redirect()->route('welcome')->with('success', 'Usuario eliminado correctamente.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // 1. Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ignora el email del usuario actual
            'password' => 'nullable|string|min:8|confirmed', // Ejemplo para la contraseña
            // Agrega otras reglas de validación para tus campos
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 2. Encontrar al usuario que se va a actualizar
        $user = User::findOrFail($id);

        // 3. Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        // Actualizar la contraseña si se proporciona
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        // 4. Redirigir al usuario a alguna página con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
    }

    // REVISAR BIEN ESTE METODO

    public function show($id) // Generalmente el método show recibe un ID como parámetro
    {
        // Aquí va la lógica para mostrar un usuario específico
        // Por ejemplo, buscar el usuario por su ID
        $user = \App\Models\User::findOrFail($id); // Asegúrate de usar el modelo correcto
        return view('users.show', ['user' => $user]); // Pasar el usuario a una vista
    }

}


