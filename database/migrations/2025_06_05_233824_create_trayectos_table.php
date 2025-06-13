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
            $table->integer('numero_orden')->nullable();
            $table->string('nombre_trayecto'); //'Orden numérico del trayecto (ej. 1 para Trayecto I, 2 para Trayecto II).'); // Por ejemplo: "Trayecto I", "Trayecto II", etc.
            $table->text('descripcion')->nullable(); // Opcional, para una descripción del trayecto
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
