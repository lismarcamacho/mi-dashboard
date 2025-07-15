<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Elimina la columna 'anio_cohorte'.
     */
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Verifica si la columna existe antes de intentar eliminarla para evitar errores
            if (Schema::hasColumn('estudiantes', 'anio_cohorte')) {
                $table->dropColumn('anio_cohorte');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Revierte la eliminación: añade la columna 'anio_cohorte' de nuevo.
     * IMPORTANTE: Ajusta el tipo de columna y si es nullable/tiene default
     * según cómo estaba originalmente en tu base de datos.
     * Asumimos que era un string, pero si era un entero, cambia `string` a `integer`.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Vuelve a añadir la columna 'anio_cohorte' con su definición original
            // Por ejemplo, si era un string y era nullable:
            $table->string('anio_cohorte', 10)->nullable(); // Ajusta el tamaño (ej. 10) según tu necesidad
            // Si no era nullable y tenía un valor por defecto:
            // $table->integer('anio_cohorte')->default(2023); // Si era un entero y con default
        });
    }
};
