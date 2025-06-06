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
        Schema::create('trayectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_trayecto'); // Por ejemplo: "Trayecto I", "Trayecto II", etc.
            $table->text('descripcion')->nullable(); // Opcional, para una descripción del trayecto
            $table->foreignId('especialidad_id')->constrained('especialidades')->onDelete('cascade'); // Clave foránea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trayectos');
    }
};
