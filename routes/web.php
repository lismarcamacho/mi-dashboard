<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    
});

// routes/web.php

//Route::get('admin/profile', [PerfilController::class, 'index'])->name('admin.profile');

Route::get('/admin/profile', [PerfilController::class, 'index'])->name('profile.index');

Route::get('/admin/password', [PerfilController::class, 'showChangePasswordForm'])->name('profile.update-password-form');
Route::post('/profile/cambiar-clave', [PerfilController::class, 'cambiarClave'])->name('profile.cambiarClave');



Route::resource('users', UsuarioController::class);


// Ruta para mostrar una lista de usuarios (asumiendo un método 'index' en el controlador)
Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');

// Ruta para mostrar el formulario de creación de un nuevo usuario (asumiendo un método 'create')
Route::get('/users/crear', [UsuarioController::class, 'create'])->name('users.create');

// Ruta para guardar un nuevo usuario (asumiendo un método 'store')
Route::post('/users', [UsuarioController::class, 'store'])->name('users.store');

// Ruta para mostrar los detalles de un usuario específico (asumiendo un método 'show')
Route::get('/users/{user}', [UsuarioController::class, 'show'])->name('users.show');

// Ruta para mostrar el formulario de edición de un usuario (asumiendo un método 'edit')
Route::get('/users/{user}/edit', [UsuarioController::class, 'edit'])->name('users.edit');

// Ruta para actualizar un usuario existente (asumiendo un método 'update')
Route::put('/users/{user}', [UsuarioController::class, 'update'])->name('users.update');
Route::patch('/users/{user}', [UsuarioController::class, 'update'])->name('users.update');

// Ruta para eliminar un usuario (asumiendo un método 'destroy')
Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');