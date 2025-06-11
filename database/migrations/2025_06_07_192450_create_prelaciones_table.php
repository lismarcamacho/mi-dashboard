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
        Schema::create('prelaciones', function (Blueprint $table) {
            $table->id(); // Clave primaria auto-incrementable para cada relación de prelación

            // Clave foránea que apunta a la entrada de la malla curricular que NECESITA UN REQUISITO.
            // Es decir, la unidad curricular que se desea cursar.
            $table->foreignId('id_malla_afectada')
                  ->constrained('mallas_curriculares') // Asume que tu tabla de mallas curriculares se llama 'mallas_curriculares'
                  ->onUpdate('cascade')
                  ->onDelete('cascade') // Si se borra la entrada de malla afectada, sus prelaciones también se borran.
                  ->comment('ID de la entrada en mallas_curriculares que tiene este requisito.');

            // Clave foránea que apunta a la entrada de la malla curricular que ES EL REQUISITO.
            // Es decir, la unidad curricular que debe haberse cursado/aprobado.
            $table->foreignId('id_malla_requisito')
                  ->constrained('mallas_curriculares') // Asume que tu tabla de mallas curriculares se llama 'mallas_curriculares'
                  ->onUpdate('cascade')
                  ->onDelete('cascade') // Si se borra la entrada de malla que es un requisito, las prelaciones que dependen de ella también se borran.
                  ->comment('ID de la entrada en mallas_curriculares que actúa como requisito.');

            // Tipo de prelación (ej. Pre-requisito, Co-requisito).
            $table->string('tipo_prelacion', 50)->nullable(false)->comment('Tipo de la relación de prelación (ej: Pre-requisito, Co-requisito).');

            // Índice único para evitar duplicados en las relaciones de prelación.
            // Una unidad curricular no puede tener el mismo requisito dos veces con el mismo tipo.
            $table->unique(['id_malla_afectada', 'id_malla_requisito', 'tipo_prelacion'], 'prelacion_unique');

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('prelaciones');
    }
};