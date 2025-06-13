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
        Schema::table('trayectos', function (Blueprint $table) {
            // *** CORRECCIÓN CLAVE AQUÍ ***
            // 1. Primero, elimina la restricción de clave foránea.
            //    Laravel nombra las restricciones automáticamente, generalmente 'nombre_tabla_columna_foreign'.
            //    Para 'especialidad_id' en 'trayectos', suele ser 'trayectos_especialidad_id_foreign'.
            //    Puedes usar ->dropConstrainedForeignId() si no necesitas el nombre exacto de la restricción.
            //$table->dropForeign(['especialidad_id']);
            
            // 2. Luego, elimina la columna.
           // $table->dropColumn('especialidad_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('trayectos', function (Blueprint $table) {
            // Para revertir esta migración, añade la columna de nuevo como estaba originalmente.
           // $table->foreignId('especialidad_id')
            //      ->constrained('especialidades')
           //       ->onDelete('cascade'); // Asegúrate de replicar el onDelete original.
        });
    }
};
