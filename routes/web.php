<?php

use App\Http\Controllers\CarreraController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use App\Actions\Fortify\ResetUserPassword;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\SearchController;
use App\Models\Carrera;

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
/*
|  puede definir una ruta y un controlador para capturar
| las palabras clave enviadas en el navvar superior, como se muestra a continuación:
*/
Route::match(
    ['get', 'post'],
    '/navbar/search',
    'SearchController@showNavbarSearchResults'
);
Route::match(['get', 'post'], '/nav-bar/search', [SearchController::class, 'showNavBarSearchResults'])->name('nav-bar-search');


/* ruta a Controlador de notificaciones */
Route::get(
    'notifications/get',
    [App\Http\Controllers\NotificationsController::class, 'getNotificationsData']
)->name('notifications.get');

// routes/web.php

//Route::get('admin/profile', [PerfilController::class, 'index'])->name('admin.profile');

// ****************************OJO NO MOVER MIDDLEWARE**********************
Route::middleware(['auth'])->group(function () {



Route::get('/admin/profile', [PerfilController::class, 'index'])->name('profile.index');

Route::get('/admin/password', [PerfilController::class, 'showChangePasswordForm'])->name('profile.update-password-form');
Route::post('/profile/cambiar-clave', [PerfilController::class, 'cambiarClave'])->name('profile.cambiarClave');



Route::resource('users', UsuarioController::class);


// Ruta para mostrar una lista de usuarios (asumiendo un método 'index' en el controlador)
Route::get('/users', [UsuarioController::class, 'index'])->name('users.index');
Route::get('/users', [PerfilController::class, 'index'])->name('users.index');
// Ruta para mostrar el formulario de creación de un nuevo usuario (asumiendo un método 'create')
//Route::get('/users/crear', [UsuarioController::class, 'create'])->name('users.create');

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

Route::resource('/carreras', CarreraController::class)->names('carreras');
Route::resource('admin/users/roles', RoleController::class);
//Route::resource('/roles', RoleController::class)->names('roles');;
Route::resource('admin/users/permisos', PermisoController::class);
Route::resource('roles', RoleController::class);
Route::resource('/users', AsignarController::class)->names('asignar');

Route::put('roles/{role}/permissions', [RoleController::class, 'update'])->name('roles.update');

}); // **************************************FIN MIDDLEWARE***************************



Route::post('password/reset', [ResetUserPassword::class, 'reset'])->name('password.update');
// PENDIENTE POR RENOMBRAR TODAS LAS RUTAS, EL MODELO, LA MIGRACION A ESPECIALIDAD


//Route::get('/carrera/crear', [CarreraController::class, 'create'])->name('carrera.create');

// PENDIENTE REVISAR BIEN 
Route::prefix('admin')->group(function () {
    Route::get('/carreras', [CarreraController::class, 'index'])->name('carreras.index');
    Route::get('/carreras/create', [CarreraController::class, 'create'])->name('carreras.create'); // administra el formulario para crear una nueva especialidad
    Route::post('/carreras', [CarreraController::class, 'store'])->name('carreras.store');
    Route::get('/carreras/{carreras}', [CarreraController::class, 'show'])->name('carreras.show');
    Route::get('/carreras/{carrera}/edit', [CarreraController::class, 'edit'])->name('carreras.edit');
    Route::put('/carreras/{carrera}', [CarreraController::class, 'update'])->name('carreras.update');
    Route::delete('/carreras/{carrera}', [CarreraController::class, 'destroy'])->name('carreras.destroy');
});

Route::post('/admin/carreras', [CarreraController::class, 'store'])->name('admin.carreras.store')->middleware('web');






Route::get('/admin/test', function () {
    return view('testadminlte');
});