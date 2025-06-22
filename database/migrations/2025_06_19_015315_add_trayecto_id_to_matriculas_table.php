// database/migrations/YYYY_MM_DD_HHMMSS_add_trayecto_id_to_matriculas_table.php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Para operaciones de base de datos directas
use App\Models\Trayecto; // Asegúrate de importar tu modelo Trayecto
use App\Models\Matricula; // Asegúrate de importar tu modelo Matricula

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // 1. Añadir la nueva columna para la clave foránea
            // Es importante que sea unsignedBigInteger para que coincida con el tipo 'id' de la tabla 'trayectos'
            $table->foreignId('trayecto_id')->nullable()->after('trayecto'); // La hacemos nullable temporalmente

            // 2. Migrar datos existentes (si los hay)
            // Esto es si quieres convertir los nombres de trayecto existentes a IDs
            // Si no tienes datos o no te importa la conversión, puedes comentar este bloque.
            DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Desactivar FK checks temporalmente
            $this->updateExistingTrayectoData(); // Llama a un método auxiliar para la migración de datos
            DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Reactivar FK checks

            // 3. Añadir la restricción de clave foránea
            // Si la columna 'trayecto_id' no es nullable en la DB, quita ->nullable()
            $table->foreign('trayecto_id')->references('id')->on('trayectos')->onDelete('set null'); // O 'cascade' si quieres borrar matrículas al borrar un trayecto

            // 4. Eliminar la columna antigua 'trayecto' (string)
            $table->dropColumn('trayecto');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            // 1. Re-añadir la columna antigua 'trayecto' (string)
            $table->string('trayecto', 50)->nullable(); // Hazla nullable si no quieres problemas al revertir

            // 2. Revertir la migración de datos (si la hiciste en up())
            // Esto es muy difícil de hacer de forma fiable sin guardar los IDs anteriores.
            // A menudo, las migraciones de datos no son reversibles de forma perfecta.
            // Puedes dejar este bloque vacío o lanzar una excepción.
            // throw new \RuntimeException('Esta migración de datos no es completamente reversible.');

            // 3. Eliminar la restricción de clave foránea
            $table->dropForeign(['trayecto_id']);

            // 4. Eliminar la columna 'trayecto_id'
            $table->dropColumn('trayecto_id');
        });
    }

    /**
     * Método auxiliar para migrar datos de 'trayecto' (string) a 'trayecto_id' (FK).
     * Este método se ejecuta DENTRO de la migración.
     */
    private function updateExistingTrayectoData()
    {
        // Obtener todos los trayectos existentes para mapear nombres a IDs
        $trayectosMap = Trayecto::pluck('id', 'nombre_trayecto')->toArray();

        // Iterar sobre las matrículas y actualizar el trayecto_id
        // Esto puede ser intensivo en memoria para muchos registros.
        // Considera usar chunkById() para grandes tablas.
        Matricula::chunkById(1000, function ($matriculas) use ($trayectosMap) {
            foreach ($matriculas as $matricula) {
                // Asegúrate de que el nombre de la columna antigua sea 'trayecto'
                $oldTrayectoName = $matricula->getRawOriginal('trayecto'); // Obtiene el valor original del string

                if (isset($trayectosMap)) {
                    $matricula->trayecto_id = $trayectosMap;
                    $matricula->saveQuietly(); // saveQuietly para no disparar eventos ni actualizar timestamps
                } else {
                    // Si el nombre del trayecto antiguo no se encuentra en la tabla 'trayectos',
                    // puedes dejar trayecto_id como NULL o asignar un ID por defecto.
                    $matricula->trayecto_id = null;
                }
            }
        });
    }
};