<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('unidades_curriculares', function (Blueprint $table) {
            // Paso 1: Eliminar la columna 'codigo' existente.
            // ¡ADVERTENCIA: ESTO BORRARÁ TODOS LOS DATOS EN LA COLUMNA 'codigo'!
            // Si tienes datos, HAZ UN BACKUP antes de ejecutar esta migración.
            if (Schema::hasColumn('unidades_curriculares', 'codigo')) {
                // Si la columna es única, puede que necesites eliminar el índice primero.
                // Si tienes problemas, descomenta la línea de dropUnique.
                // $table->dropUnique(['codigo']); 
                $table->dropColumn('codigo');
            }
        });

        // Volvemos a modificar la tabla para añadir la columna en la nueva posición.
        // Esto se hace en un bloque Schema::table separado porque no puedes
        // añadir y eliminar la misma columna en el mismo bloque en ciertas bases de datos.
        Schema::table('unidades_curriculares', function (Blueprint $table) {
            // Paso 2: Volver a añadir la columna 'codigo' en la posición deseada.
            $table->string('codigo', 70)
                  ->unique() // Asegúrate de que siga siendo única
                  ->nullable(false)
                  ->comment('Código único de la unidad curricular (ej: CALC101).')
                  ->after('id'); // Esto la colocará inmediatamente después de 'id'.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        // Para revertir este cambio, necesitamos eliminar 'codigo' y volver a añadirla
        // en la posición original (después de 'nombre').
        Schema::table('unidades_curriculares', function (Blueprint $table) {
            if (Schema::hasColumn('unidades_curriculares', 'codigo')) {
                // $table->dropUnique(['codigo']);
                $table->dropColumn('codigo');
            }
        });

        Schema::table('unidades_curriculares', function (Blueprint $table) {
            $table->string('codigo', 70)
                  ->unique()
                  ->nullable(false)
                  ->comment('Código único de la unidad curricular (ej: CALC101).')
                  ->after('nombre'); // Mueve 'codigo' de vuelta después de 'nombre'.
        });
    }
};
