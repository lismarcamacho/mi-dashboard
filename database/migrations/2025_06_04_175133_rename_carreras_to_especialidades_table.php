<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Renombrar la tabla 'carreras' a 'especialidades'
        Schema::rename('carreras', 'especialidades');

        // 2. Si también tienes una columna 'nombre_carrera' que quieres renombrar a 'nombre_especialidad'
        Schema::table('especialidades', function (Blueprint $table) {
            $table->renameColumn('nombre_carrera', 'nombre_especialidad');
            // Si tienes un 'codigo_carrera', también lo renombrarías
            $table->renameColumn('codigo_carrera', 'codigo_especialidad');
            // Si tienes una clave foránea que aún apunte a 'carrera_id', también la renombrarías si fuera el caso
            // $table->renameColumn('carrera_id', 'especialidad_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Revertir el nombre de la tabla 'especialidades' a 'carreras'
        Schema::rename('especialidades', 'carreras');

        // 2. Revertir el nombre de la columna 'nombre_especialidad' a 'nombre_carrera'
        Schema::table('carreras', function (Blueprint $table) {
            $table->renameColumn('nombre_especialidad', 'nombre_carrera');
            // Revertir también el 'codigo_especialidad' si lo renombraste
            $table->renameColumn('codigo_especialidad', 'codigo_carrera');
            // Revertir también la clave foránea si la renombraste
            // $table->renameColumn('especialidad_id', 'carrera_id');
        });
    }
};
