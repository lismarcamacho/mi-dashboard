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
        Schema::table('estudiantes', function (Blueprint $table) {
            // Eliminar la columna 'status_activo'
            $table->dropColumn('estatus_activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Revertir la eliminación: agregar la columna 'status_activo' de nuevo
            // Asegúrate de definir el tipo y valor por defecto si lo tenías originalmente.
            // Por ejemplo, si era un booleano con valor por defecto true:
            $table->boolean('estatus_activo')->default(true); // O el valor por defecto que tenías
        });
    }
};
