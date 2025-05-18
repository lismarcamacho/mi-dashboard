<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PerfilController extends Controller
{
    public function index()
    {
        $user = auth()->user();  // Obtiene el usuario autenticado
        return view('profile.index', compact('user')); // Pasa los usuarios a la vista
    }
}
