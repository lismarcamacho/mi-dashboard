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
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_especialidad', 10); // Podría ser único si cada carrera tiene un código único
            $table->string('nombre_especialidad', 75); // Nombre de la carrera
            $table->string('duracion', 25)->nullable(); // Duración general de la carrera
            $table->string('descripcion', 255)->nullable(); // Descripción de la carrera
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especialidades');
    }
};
