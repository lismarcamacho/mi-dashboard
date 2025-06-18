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
        Schema::create('programa_especialidad', function (Blueprint $table) {
            // Clave primaria compuesta si lo deseas, o autoincremental si no
            $table->id(); // Opcional, pero recomendado para manejar la fila directamente
            $table->foreignId('programa_id')->constrained('programas')->onDelete('cascade');
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade');

            // Asegura que la combinación de programa_id y especialidad_id sea única
            $table->unique(['programa_id', 'especialidad_id']);

            $table->timestamps(); // Opcional para la tabla pivote, pero útil para auditoría
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_especialidad');
    }
};
