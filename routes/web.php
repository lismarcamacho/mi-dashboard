<?php


use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermisoController;
use App\Actions\Fortify\ResetUserPassword;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\MallaCurricularController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TituloController;
use App\Http\Controllers\TrayectoController;
use App\Http\Controllers\UnidadCurricularController;

use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\SeccionController;


use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

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

// agregado 17/06/25
Route::get('/search', [SearchController::class, 'index']); // Estilo moderno, pero requiere importación


/* ruta a Controlador de notificaciones */
Route::get(
    'notifications/get',
    [App\Http\Controllers\NotificationsController::class, 'getNotificationsData']
)->name('notifications.get');

// routes/web.php

//Route::get('admin/profile', [PerfilController::class, 'index'])->name('admin.profile');

// ****************************OJO NO MOVER MIDDLEWARE**********************
Route::middleware(['auth'])->group(function () {



Route::get('/admin/password', [PerfilController::class, 'showChangePasswordForm'])->name('profile.update-password-form');
Route::post('/profile/cambiar-clave', [PerfilController::class, 'cambiarClave'])->name('profile.cambiarClave');
//Route::get('/profile', [PerfilController::class, 'index'])->name('profile.show'); 
Route::get('/profile', [PerfilController::class, 'index'])->name('profile.index');
Route::get('/profile/edit', [PerfilController::class, 'edit'])->name('profile.edit');
//Route::get('/profile/{profile}', [CarreraController::class, 'show'])->name('profile.show');
Route::put('/profile/{id}', [PerfilController::class, 'update'])->name('profile.update');

//----------------------------------------------------------------------------------------------------------//
Route::resource('users', UsuarioController::class);
// Ruta para mostrar una lista de usuarios (asumiendo un método 'index' en el controlador)
Route::get('/users', [UsuarioController::class, 'index'])->name('users.listUser');

Route::get('/users', [PerfilController::class, 'index'])->name('users.index');
// Ruta para mostrar el formulario de creación de un nuevo usuario (asumiendo un método 'create')
//Route::get('/users/crear', [UsuarioController::class, 'create'])->name('users.create');
// Si quieres que la maneje otro controlador (por ejemplo, UserController)
Route::get('/users/create', [UsuarioController::class, 'create'])->name('users.create');
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
//Route::delete('/users/{user}', [UsuarioController::class, 'destroy'])->name('users.destroy');

//----------------------------------------------------------------------------------------------------------//

Route::resource('/roles', RoleController::class)->names('roles');;
Route::resource('admin/users/permisos', PermisoController::class);

//----------------------------------------------------------------------------------------------------------//

Route::resource('admin/users/roles', RoleController::class);
Route::resource('roles', RoleController::class);
Route::get('/roles', [UsuarioController::class, 'index'])->name('roles.index');
Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
Route::put('roles/{role}/permissions', [RoleController::class, 'update'])->name('roles.update');
Route::get('/roles/{role}/editarpermisos', [RoleController::class, 'edit'])->name('roles.edit');
Route::get('roles/editar-nombre/{role}', [RoleController::class, 'editName'])->name('roles.editName');

// NO CAMBIAR
Route::put('roles/{role}/{id}', [RoleController::class, 'update'])->name('roles.update'); // Para guardar el nombre modificado
// Example for POST route
Route::post('roles/{role}', [RoleController::class, 'update'])->name('roles.update');

// OJO CON ESTO: DE ABAJO PUEDE DAR EROR:

//Route::put('roles/{role}/{id}', [RoleController::class, 'updatePermisos'])->name('roles.updatePermisos'); // Para guardar el nombre modificado
// Example for POST route
//Route::post('roles/{role}', [RoleController::class, 'updatePermisos'])->name('roles.updatePermisos');

//----------------------------------------------------------------------------------------------------------//

Route::resource('/users', AsignarController::class)->names('asignar');
Route::get('/users/{user}/edit-roles', [AsignarController::class, 'edit'])->name('asignar.edit-roles');
Route::put('/users/{user}/assign-roles', [AsignarController::class, 'update'])->name('asignar.assign-roles');

// COMO EL CONTROLADOR PROGRAMAS FUE CREADO COMO UN RECURSO NO SE NECESITA COLOCAR TANTAS RUTAS
Route::resource('admin/programas', ProgramaController::class);
Route::get('/admin/programas/{id}', [ProgramaController::class, 'show'])->name('programas.show');
//----------------------------------------------------------------------------------------------------------//

Route::resource('/especialidades', EspecialidadController::class)->names('especialidades');
Route::prefix('admin')->group(function () {
    Route::get('/especialidades', [EspecialidadController::class, 'index'])->name('especialidades.index');
    Route::get('/especialidades/create', [EspecialidadController::class, 'create'])->name('especialidades.create'); // administra el formulario para crear una nueva especialidad
    Route::post('/especialidades', [EspecialidadController::class, 'store'])->name('especialidades.store');
    Route::get('/especialidades/{especialidad}', [EspecialidadController::class, 'show'])->name('especialidades.show');
    Route::get('/especialidades/{especialidad}/edit', [EspecialidadController::class, 'edit'])->name('especialidades.edit');
    Route::put('/especialidades/{especialidad}', [EspecialidadController::class, 'update'])->name('especialidades.update');
    Route::delete('/especialidades/{especialidad}', [EspecialidadController::class, 'destroy'])->name('especialidades.destroy');
    // Ruta para mostrar la estructura del pensum de una especialidad
    Route::get('/especialidades/{id}/malla', [EspecialidadController::class, 'showMallaStructure'])->name('especialidades.malla_structure');

});

Route::resource('/titulos', TituloController::class)->names('titulos');; // Esto crea varias rutas: index, create, store, show, edit, update, destroy
Route::prefix('admin')->group(function () {
    Route::get('/titulos', [TituloController::class, 'index'])->name('titulos.index');
    Route::get('/titulos/create', [TituloController::class, 'create'])->name('titulos.create'); // administra el formulario para crear una nueva especialidad
    Route::post('/titulos', [TituloController::class, 'store'])->name('titulos.store');
    Route::get('/titulos/{titulo}', [TituloController::class, 'show'])->name('titulos.show');
    Route::get('/titulos/{titulo}/edit', [TituloController::class, 'edit'])->name('titulos.edit');
    Route::put('/titulos/{titulo}', [TituloController::class, 'update'])->name('titulos.update');
    Route::delete('/titulos/{titulo}', [TituloController::class, 'destroy'])->name('titulos.destroy');
});

Route::resource('trayectos', TrayectoController::class)->names('trayectos');
Route::prefix('admin')->group(function () {
    Route::get('/trayectos', [TrayectoController::class, 'index'])->name('trayectos.index');
    Route::get('/trayectos/create', [TrayectoController::class, 'create'])->name('trayectos.create'); // administra el formulario para crear una nueva especialidad
    Route::post('/trayectos', [TrayectoController::class, 'store'])->name('trayectos.store');
    Route::get('/trayectos/{trayecto}', [TrayectoController::class, 'show'])->name('trayectos.show');
    Route::get('/trayectos/{trayecto}/edit', [TrayectoController::class, 'edit'])->name('trayectos.edit');
    Route::put('/trayectos/{trayecto}', [TrayectoController::class, 'update'])->name('trayectos.update');
    Route::delete('/trayectos/{trayecto}', [TrayectoController::class, 'destroy'])->name('trayectos.destroy');
});

Route::resource('admin/unidades-curriculares', UnidadCurricularController::class)->names('unidades-curriculares');
Route::resource('admin/mallas-curriculares', MallaCurricularController::class)->names('mallas-curriculares');

Route::prefix('admin')->group(function () {
    Route::resource('mallas-curriculares', MallaCurricularController::class);

    // Rutas adicionales que ya tenías para unidades curriculares, si son necesarias.
    Route::post('mallas-curriculares/{mallaCurricular}/unidades/attach', [MallaCurricularController::class, 'attachUnidadCurricular'])->name('mallas-curriculares.attach-unidad-curricular');
    Route::delete('mallas-curriculares/{mallaCurricular}/unidades/{unidadCurricular}/detach', [MallaCurricularController::class, 'detachUnidadCurricular'])->name('mallas-curriculares.detach-unidad-curricular');
    Route::get('mallas-curriculares/{mallaCurricular}/unidades/manage', [MallaCurricularController::class, 'manageUnidadesCurriculares'])->name('mallas-curriculares.manage-unidades-curriculares');
});

Route::resource('admin/estudiantes', EstudianteController::class);


Route::prefix('admin')->group(function () {

    // Rutas de recursos para Estudiantes
    Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes.index'); // Muestra todos los estudiantes
    Route::get('/estudiantes/{estudiante}', [EstudianteController::class, 'show'])->name('estudiantes.show'); // Muestra un estudiante específico
});
Route::resource('admin/matriculas', MatriculaController::class);


Route::prefix('admin')->group(function () {
 Route::resource('secciones', SeccionController::class)->parameters([
        'secciones' => 'seccion' // ¡IMPORTANTE! Esto asegura que el comodín sea {seccion}
    ]);

});

}); // **************************************FIN MIDDLEWARE***************************



Route::post('password/reset', [ResetUserPassword::class, 'reset'])->name('password.update');
// PENDIENTE POR RENOMBRAR TODAS LAS RUTAS, EL MODELO, LA MIGRACION A ESPECIALIDAD


//Route::get('/carrera/crear', [CarreraController::class, 'create'])->name('carrera.create');

// PENDIENTE REVISAR BIEN 


//Route::post('/admin/carreras', [CarreraController::class, 'store'])->name('admin.carreras.store')->middleware('web');






Route::get('/admin/test', function () {
    return view('testadminlte');
});