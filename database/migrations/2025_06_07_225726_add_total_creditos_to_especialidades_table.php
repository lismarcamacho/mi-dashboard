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
        Schema::table('especialidades', function (Blueprint $table) {
            // Añade la columna 'total_creditos_requeridos'
            // Asumo que los créditos totales son enteros, si pueden ser decimales, usa 'decimal'.
            $table->integer('total_creditos_requeridos')
                  ->nullable() // Puede ser nulo si no se conoce de inmediato, o 'false' si es obligatorio.
                  ->comment('Total de créditos requeridos para optar por el título de esta especialidad.');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('especialidades', function (Blueprint $table) {
            // Elimina la columna si se revierte la migración
            $table->dropColumn('total_creditos_requeridos');
        });
    }
};
