<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones (añade las columnas).
     */
    public function up(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Añadir cohorte_ingreso (texto para AAAA-PP, nullable para flexibilidad inicial)
            $table->string('cohorte_ingreso', 10)->nullable()->after('parroquia'); 
            // 'after' es opcional, lo coloca después de la columna 'parroquia'.
            // Puedes ajustarlo según donde quieras que aparezca en tu tabla.

            // Añadir cohorte_actual (texto para AAAA-PP, nullable para flexibilidad inicial)
            $table->string('cohorte_actual', 10)->nullable()->after('cohorte_ingreso');

            // Añadir estado_estudiante (texto, con un valor por defecto 'Activo')
            // Puedes ajustar la longitud máxima si sabes que tus estados serán más largos.
            $table->string('estado_estudiante', 50)->default('Activo')->after('cohorte_actual'); 
        });
    }

    /**
     * Revierte las migraciones (elimina las columnas).
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Eliminar las columnas en caso de rollback
            $table->dropColumn('estado_estudiante');
            $table->dropColumn('cohorte_actual');
            $table->dropColumn('cohorte_ingreso');
        });
    }
};
