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
        Schema::table('trayectos', function (Blueprint $table) {
            // Añade la columna 'programa_id'.
            // Es buena práctica permitir que sea nullable() inicialmente si ya tienes datos existentes
            // que aún no tienen un programa asociado, para evitar errores de integridad.
            $table->foreignId('programa_id')
                  ->nullable() // Permite que el campo sea nulo temporalmente
                  ->constrained('programas') // Establece la relación con la tabla 'programas'
                  ->onDelete('cascade'); // O 'set null' si quieres que el trayecto persista sin programa al eliminar el programa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            // Importante: primero elimina la clave foránea, luego la columna
            $table->dropForeign(['programa_id']);
            $table->dropColumn('programa_id');
        });
    }
};