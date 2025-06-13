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
    Schema::create('malla_curricular_trayecto', function (Blueprint $table) {
        // Claves Foráneas de la tabla pivote
        $table->foreignId('malla_curricular_id')->constrained('mallas_curriculares')->onDelete('cascade');
        $table->foreignId('trayecto_id')->constrained('trayectos')->onDelete('cascade');

        // Establecer ambas FKs como la clave primaria compuesta de la tabla pivote
        $table->primary(['malla_curricular_id', 'trayecto_id']);
         $table->integer('minimo_aprobatorio')->nullable(); 

        // Campos opcionales para la relación N:M si necesitas almacenar datos adicionales sobre la asociación
        // Por ejemplo, si el orden de los trayectos en una malla es importante:
        // $table->integer('orden')->nullable();
        // O si un trayecto tiene un nombre diferente solo para una malla específica:
        // $table->string('nombre_en_malla')->nullable();

        $table->timestamps(); // Para saber cuándo se creó/actualizó esta asociación
    });
}

public function down(): void
{
    Schema::dropIfExists('malla_curricular_trayecto');
}
};
