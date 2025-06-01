<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; // Para validar los datos




class PerfilController extends Controller
{
    public function index()
    {
        $user = auth::user();  // Obtiene el usuario autenticado
        return view('profile.index', compact('user')); // Pasa los usuarios a la vista
    }

    public function showChangePasswordForm()
    {
        return view('profile.update-password-form');
    }

    public function edit(User $user)
    {
        // Lógica para mostrar el formulario de edición del usuario
        return view('profile.edit', compact('user')); // Ejemplo de retorno de una vista
    }




    public function cambiarClave(Request $request)
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

        try {

            $user = Auth::user();

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('profile.index')->with('success', 'Contraseña actualizada correctamente.');
        } catch (\Exception $e) {
            // Log the error: Log::error('Error al actualizar la contraseña: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un error al actualizar la contraseña. Por favor, inténtalo de nuevo.');
        }
    }

  /*  public function update(Request $request, $id)
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
        return redirect()->route('profile.index')->with('success', 'Usuario actualizado correctamente.');
    } */

        public function update(Request $request, string $id)
    {
        $validacion = $request->validate([

            'name' => 'required|string|unique:User,name,'.$id.'|max:15',
            'email' => 'required|string|unique:User,email,'.$id.'|max:25',

        ]);
        $user = User::find($id);
        $user->name = $request->input('name'); //
        $user->email = $request->input('email');
     
        $user->save();
       // 
       //
        //return session()->flash('success', 'Actualizada exitosamente');
        return back()->with('success', 'Perfil de usuario Actualizado exitosamente');
        //return 'Actualización Exitosa';
    }





    // REVISAR BIEN ESTE METODO

    public function show($id) // Generalmente el método show recibe un ID como parámetro
    {
        // Aquí va la lógica para mostrar un usuario específico
        // Por ejemplo, buscar el usuario por su ID
        $user = \App\Models\User::findOrFail($id); // Asegúrate de usar el modelo correcto
        return view('users.show', ['user' => $user]); // Pasar el usuario a una vista
    }

    //public function destroy(User $user)
    //{
    //    // Lógica para eliminar el usuario
    //    $user->delete();

        // Redireccionar o devolver una respuesta
    //    return redirect()->route('welcome')->with('success', 'Usuario eliminado correctamente.');
   // }
}
