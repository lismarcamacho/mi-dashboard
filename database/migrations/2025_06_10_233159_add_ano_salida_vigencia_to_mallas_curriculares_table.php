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
            $table->integer('anio_salida_vigencia')->nullable()->after('año_de_vigencia_de_entrada_malla')->comment('Año en que esta entrada de la malla entra en vigencia (opcional).'); // Puedes ajustar 'after' si quieres que esté en otra posición
            // Si tu columna de 'año_entrada_vigencia' se llama diferente, ajusta el nombre
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mallas_curriculares', function (Blueprint $table) {
            $table->dropColumn('anio_salida_vigencia');
        });
    }
};