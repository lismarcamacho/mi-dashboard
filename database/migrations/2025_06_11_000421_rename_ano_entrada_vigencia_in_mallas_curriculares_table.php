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
        Schema::table('mallas_curriculares', function (Blueprint $table) {
            // Renombra la columna de 'año_entrada_vigencia' a 'anio_entrada_vigencia'
            // Asegúrate que 'año_entrada_vigencia' (con ñ) sea el nombre exacto actual en tu DB.
            $table->renameColumn('año_de_vigencia_de_entrada_malla', 'anio_de_vigencia_de_entrada_malla');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mallas_curriculares', function (Blueprint $table) {
            // Si haces rollback, renombra de nuevo a su nombre original
            $table->renameColumn('anio_de_vigencia_de_entrada_malla', 'año_de_vigencia_de_entrada_malla');
        });
    }
};