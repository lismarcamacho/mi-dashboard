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
        Schema::create('malla_trayecto', function (Blueprint $table) {
            $table->foreignId('malla_curricular_id')->constrained('mallas_curriculares')->onDelete('cascade');
            $table->foreignId('trayecto_id')->constrained('trayectos')->onDelete('cascade');
            $table->primary(['malla_curricular_id', 'trayecto_id']);

            // **¡AÑADE ESTA LÍNEA!**
            $table->integer('minimo_aprobatorio')->nullable(); // O 'required' si siempre debe haber uno

            // Opcional: si la UC es proyecto afecta directamente este valor,
            // podrías tener una bandera o una columna de tipo aquí si no se hereda directamente.
            // O una tabla de atributos por tipo de UC en la malla-trayecto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malla_trayecto');
    }
};
