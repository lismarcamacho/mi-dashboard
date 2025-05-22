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
        Schema::create('carreras', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_carrera',10)->nullable(false);
            $table->string('nombre_carrera',75)->nullable(false);
            $table->string('titulo',75)->nullable(false);
            $table->string('duración_x_titulo',25)->nullable(false);
            $table->string('descripcion',75);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carreras');
    }
};

