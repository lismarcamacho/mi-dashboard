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
            // Si telefono_movil también tenía un índice unique, elimínalo.
            // Por defecto, Laravel no crea un índice unique para campos de teléfono a menos que lo especifiques.
            // $table->dropUnique(['telefono_movil']); // Descomenta si tenías un unique aquí.

            // Luego, haz la columna nullable. Asegúrate de mantener el tipo de dato y la longitud.
            $table->string('telefono', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            // Para revertir
            // $table->string('telefono_movil', 20)->nullable(false)->change();
            // Si agregaste un unique en down, descomenta:
            // $table->unique('telefono_movil');
        });
    }
};