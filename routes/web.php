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

Route::get('admin/profile', [PerfilController::class, 'index'])->name('admin.profile');

Route::resource('users', UsuarioController::class);


// Ruta para mostrar una lista de usuarios (asumiendo un método 'index' en el controlador)
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');

// Ruta para mostrar el formulario de creación de un nuevo usuario (asumiendo un método 'create')
Route::get('/usuarios/crear', [UsuarioController::class, 'create'])->name('usuarios.create');

// Ruta para guardar un nuevo usuario (asumiendo un método 'store')
Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');

// Ruta para mostrar los detalles de un usuario específico (asumiendo un método 'show')
Route::get('/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');

// Ruta para mostrar el formulario de edición de un usuario (asumiendo un método 'edit')
Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');

// Ruta para actualizar un usuario existente (asumiendo un método 'update')
Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::patch('/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');

// Ruta para eliminar un usuario (asumiendo un método 'destroy')
Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');