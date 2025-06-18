// database/migrations/YYYY_MM_DD_HHMMSS_create_seccions_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeccionesTable extends Migration
{
    public function up()
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Ej: "01", "02"
            $table->integer('capacidad_maxima')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secciones');
    }
}