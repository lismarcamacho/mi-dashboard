<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstudianteController; // Asegúrate de que el namespace sea correcto


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/estudiantes/buscar', [EstudianteController::class, 'buscar'])->name('api.estudiantes.buscar');
