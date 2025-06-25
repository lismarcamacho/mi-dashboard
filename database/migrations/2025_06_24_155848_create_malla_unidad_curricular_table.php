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
    public function up()
    {
        Schema::create('malla_unidad_curricular', function (Blueprint $table) {
            $table->id(); // ID autoincremental para la tabla pivote

            $table->unsignedBigInteger('malla_curricular_id');
            $table->unsignedBigInteger('unidad_curricular_id');
            $table->unsignedBigInteger('trayecto_id')->nullable(); // trayecto_id puede ser opcional para la relación

            // Nuevo campo para el mínimo aprobatorio específico de esta asociación
            $table->float('minimo_aprobatorio')->default(0); // Valor por defecto, se actualizará dinámicamente

            // Definir las claves foráneas
            $table->foreign('malla_curricular_id')
                  ->references('id')
                  ->on('mallas_curriculares')
                  ->onDelete('cascade');

            $table->foreign('unidad_curricular_id')
                  ->references('id')
                  ->on('unidades_curriculares')
                  ->onDelete('cascade');

            $table->foreign('trayecto_id')
                  ->references('id')
                  ->on('trayectos')
                  ->onDelete('set null');

            // Añadir un índice único para asegurar que la combinación de malla, unidad curricular y trayecto sea única
            $table->unique(['malla_curricular_id', 'unidad_curricular_id', 'trayecto_id'], 'malla_uc_tray_unique');

            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('malla_unidad_curricular');
    }
};
