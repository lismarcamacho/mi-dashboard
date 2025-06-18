// database/migrations/YYYY_MM_DD_HHMMSS_create_matriculas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();

            // Claves Foráneas (asegurarse que las tablas referenciadas existan)
            $table->foreignId('estudiante_id')
                  ->constrained('estudiantes')
                  ->onDelete('cascade');

            $table->foreignId('programa_id')
                  ->constrained('programas')
                  ->onDelete('cascade');

            $table->foreignId('seccion_id')
                  ->nullable()
                  ->constrained('secciones') // Referencia a la tabla 'secciones'
                  ->onDelete('set null');

            // Atributos Específicos de la Matrícula
            $table->date('fecha_inscripcion');
            $table->string('periodo_academico', 100);
            $table->string('trayecto', 50);

            //$table->string('estado', 255)->default('Activo');
            $table->string('condicion_inscripcion', 255);
            $table->string('condicion_cohorte', 255);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
