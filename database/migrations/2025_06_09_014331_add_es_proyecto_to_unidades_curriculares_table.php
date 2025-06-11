<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('unidades_curriculares', function (Blueprint $table) {
            // Añade la columna 'es_proyecto' como booleana
            // Por defecto, se establecerá a false, indicando que no es una materia de proyecto
            $table->boolean('es_proyecto')->default(false)->after('nombre'); // Puedes ajustar 'after' según tu estructura
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidades_curriculares', function (Blueprint $table) {
            // Elimina la columna 'es_proyecto' si se revierte la migración
            $table->dropColumn('es_proyecto');
        });
    }
};
