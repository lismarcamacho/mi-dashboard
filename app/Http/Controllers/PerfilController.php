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
    //public function edit(string $id)
    //{
       // $user = User::find($id);
        $user = Auth::user();
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

    public function update(Request $request, string $id)
    {
        // 1. Validar los datos del formulario
     //  $validator = Validator::make($request->all(), [
     //       'name' => 'required|string|unique:Users,name|min:5|max:15', //. $id,
     //       'email' => 'required|string|email|unique:Users,email|max:120', //. $id, // Ignora el email del usuario actual
          // Ejemplo para la contraseña
             //Agrega otras reglas de validación para tus campos
    //    ]);
    //    if ($validator->fails()) {
     //       return redirect()->back()->withErrors($validator)->withInput();
            
     //   }
        $validacion = $request->validate([
            'name' => 'required|string|unique:Users,name|min:5|max:15', //. $id,
            'email' => 'required|string|email|unique:Users,email|max:120', //. $id, // Ignora el email del usuario actual
          // Ejemplo para la contraseña
             //Agrega otras reglas de validación para tus campos
        

            ]);
   

        // 2. Encontrar al usuario que se va a actualizar
        $user = User::find($id);

        // 3. Actualizar los datos del usuario
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        
 
        $user->save();
        // 4. Redirigir al usuario a alguna página con un mensaje de éxito

       // return ('usuario actualizado');
        
        return back()->with('success', 'Usuario Actualizado exitosamente');
        //return redirect()->route('profile.index')->with('success', 'Usuario actualizado correctamente.');
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
