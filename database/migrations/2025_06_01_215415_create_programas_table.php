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
        Schema::create('programas', function (Blueprint $table) {
            $table->id();  
            $table->string('codigo_programa');         
            $table->string('nombre_programa'); // Columna para el nombre del programa
            $table->date('fecha_programa')->nullable();
            $table->string('descripcion',75);
            
            $table->timestamps(); // Columnas para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programas');
    }
};
