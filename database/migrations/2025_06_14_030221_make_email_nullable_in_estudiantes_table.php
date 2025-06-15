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
        Schema::table('estudiantes', function (Blueprint $table) {
            // Cambia la columna para que acepte valores nulos
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Para revertir, si quieres que no sea nulo de nuevo, asegúrate de que no haya nulos actuales.
            // $table->string('email_personal')->nullable(false)->change();
        });
    }
};