<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            // Añade la columna 'numero_orden' como un entero.
            // Puede ser nullable inicialmente si necesitas poblar los datos manualmente después.
            // Si cada trayecto SIEMPRE tendrá un orden numérico, puedes hacerlo nullable(false).
            $table->integer('numero_orden')
                  ->nullable() // Permite que sea nulo inicialmente
                  ->after('id') // Colócalo después del ID para un orden lógico
                  ->comment('Orden numérico del trayecto (ej. 1 para Trayecto I, 2 para Trayecto II).');

            // Opcional: Si los nombres de los trayectos son únicos y quieres un índice para ello.
            // $table->unique('nombre_trayecto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            // Elimina la columna 'numero_orden' si se revierte la migración.
            $table->dropColumn('numero_orden');
        });
    }
};