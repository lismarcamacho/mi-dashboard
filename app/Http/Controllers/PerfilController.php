<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();  // Obtiene el usuario autenticado
        return view('profile.index', compact('user')); // Pasa los usuarios a la vista
    }

    public function showChangePasswordForm(){
        return view('profile.update-password-form');
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

        try{

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Contraseña actualizada correctamente.');
        }catch (\Exception $e) {
        // Log the error: Log::error('Error al actualizar la contraseña: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Hubo un error al actualizar la contraseña. Por favor, inténtalo de nuevo.');
    }
    }
}
