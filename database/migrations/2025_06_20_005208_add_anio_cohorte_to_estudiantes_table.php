<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAnioCohorteToEstudiantesTable extends Migration
{
    public function up()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Añadir la columna anio_cohorte como un año, puede ser nulo inicialmente
            $table->year('anio_cohorte')->nullable()->after('cedula'); // Puedes ajustar 'after' según tu estructura
        });
    }

    public function down()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn('anio_cohorte');
        });
    }
}