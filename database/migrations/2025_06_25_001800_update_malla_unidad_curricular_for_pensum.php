<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::table('malla_unidad_curricular', function (Blueprint $table) {
            // Añade 'minimo_aprobatorio' si no existe
            if (!Schema::hasColumn('malla_unidad_curricular', 'minimo_aprobatorio')) {
                $table->float('minimo_aprobatorio')->after('trayecto_id')->default(0);
            }

            // Añade 'tipo_uc_en_malla' si no existe
            if (!Schema::hasColumn('malla_unidad_curricular', 'tipo_uc_en_malla')) {
                $table->string('tipo_uc_en_malla')->after('minimo_aprobatorio')->nullable();
            }

            // Añade 'periodo_de_carga' si no existe
            if (!Schema::hasColumn('malla_unidad_curricular', 'periodo_de_carga')) {
                $table->string('periodo_de_carga')->after('tipo_uc_en_malla')->nullable();
            }

            // Añade 'numero_de_fase' si no existe
            if (!Schema::hasColumn('malla_unidad_curricular', 'numero_de_fase')) {
                $table->integer('numero_de_fase')->after('periodo_de_carga')->nullable();
            }

            // Opcional: Para el índice único más estricto, primero asegúrate de que no haya duplicados
            // existentes que violen la nueva regla antes de añadirla.
            // Si quieres que la combinación de (malla, unidad, trayecto, periodo, numero_fase) sea única,
            // tendrías que eliminar el índice unique anterior ('malla_uc_tray_unique')
            // si solo es (malla, unidad, trayecto), y luego añadir el nuevo:
            /*
            if (Schema::hasColumn('malla_unidad_curricular', 'malla_uc_tray_unique')) { // Verifica si el índice existe por su nombre
                $table->dropUnique('malla_uc_tray_unique');
            }
            $table->unique(['malla_curricular_id', 'unidad_curricular_id', 'trayecto_id', 'periodo_de_carga', 'numero_de_fase'], 'malla_uc_tray_periodo_fase_unique');
            */
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::table('malla_unidad_curricular', function (Blueprint $table) {
            // Asegúrate de eliminar los índices únicos si los añadiste
            // $table->dropUnique('malla_uc_tray_periodo_fase_unique');

            if (Schema::hasColumn('malla_unidad_curricular', 'numero_de_fase')) {
                $table->dropColumn('numero_de_fase');
            }
            if (Schema::hasColumn('malla_unidad_curricular', 'periodo_de_carga')) {
                $table->dropColumn('periodo_de_carga');
            }
            if (Schema::hasColumn('malla_unidad_curricular', 'tipo_uc_en_malla')) {
                $table->dropColumn('tipo_uc_en_malla');
            }
            if (Schema::hasColumn('malla_unidad_curricular', 'minimo_aprobatorio')) {
                $table->dropColumn('minimo_aprobatorio');
            }
        });
    }
};

