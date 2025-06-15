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
            // Primero, intenta eliminar el índice unique si existe.
            // Esto es crucial para evitar errores si ya se creó.
            // Si la columna no tiene un índice unique o ya fue eliminado, esto fallará,
            // pero lo ignoraremos si estamos seguros de que no existe.
            // Es mejor usar try-catch o una verificación antes de dropUnique
            // pero para simplificar, a veces se puede probar directamente.
            // Si tienes un nombre de índice personalizado, úsalo aquí. Por defecto es tabla_columna_unique.
            $table->dropUnique(['email']); // Si el nombre del índice es 'estudiantes_email_personal_unique'
            // O si no tienes certeza del nombre exacto del índice:
            // try {
            //     $table->dropUnique(['email_personal']);
            // } catch (\Illuminate\Database\QueryException $e) {
            //     // Ignorar si el índice no existe
            // }

            // Luego, haz la columna nullable
            $table->string('email')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Para revertir, podrías intentar hacerla NOT NULL de nuevo
            // $table->string('email_personal')->nullable(false)->change();
            // Y agregar el índice unique si es necesario, pero solo si no hay nulos o duplicados.
            // $table->unique('email_personal');
        });
    }
};