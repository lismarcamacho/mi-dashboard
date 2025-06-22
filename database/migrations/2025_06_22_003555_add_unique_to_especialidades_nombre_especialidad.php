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
        Schema::table('especialidades', function (Blueprint $table) {
            // Añade la restricción UNIQUE a la columna 'nombre_especialidad'
            $table->unique('nombre_especialidad');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('especialidades', function (Blueprint $table) {
            // Para deshacer la migración, necesitas el nombre del índice
            // Laravel genera un nombre por defecto como 'tablename_columnname_unique'
            $table->dropUnique(['nombre_especialidad']);
            // O podrías usar: $table->dropUnique('especialidades_nombre_especialidad_unique');
        });
    }
};