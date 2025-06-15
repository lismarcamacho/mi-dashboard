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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->string('cedula', 20)->unique()->nullable(false); // VARCHAR(20) NOT NULL UNIQUE
            $table->string('apellidos_nombres', 255)->nullable(false); // VARCHAR(100) NOT NULL
            $table->date('fecha_nacimiento')->nullable(false); // DATE NOT NULL
            $table->string('email', 150)->unique()->nullable(false); // VARCHAR(150) NOT NULL UNIQUE
            $table->string('telefono', 20)->nullable(); // VARCHAR(20) NULLABL
            $table->string('sede', 100)->nullable(false); // VARCHAR(100) NOT NULL
            $table->string('municipio', 100)->nullable(false); // VARCHAR(100) NOT NULL
            $table->string('parroquia', 100)->nullable(false); // VARCHAR(100) NOT NULL
            $table->boolean('estatus_activo')->default(true); // BOOLEAN DEFAULT TRUE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
