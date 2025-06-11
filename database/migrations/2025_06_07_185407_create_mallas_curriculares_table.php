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
        Schema::create('mallas_curriculares', function (Blueprint $table) {
            $table->id(); // Clave primaria auto-incrementable para cada entrada de la malla

            // Clave foránea a la tabla 'especialidades'
            $table->foreignId('id_especialidad')
                  ->constrained('especialidades') // Asume que tu tabla de especialidades se llama 'especialidades'
                  ->onUpdate('cascade')
                  ->onDelete('cascade') // Considera 'restrict' o 'nullOnDelete' si no quieres borrado en cascada
                  ->comment('Referencia a la especialidad a la que pertenece esta entrada de malla.');

            // Clave foránea a la tabla 'unidades_curriculares'
            $table->foreignId('id_unidad_curricular')
                  ->constrained('unidades_curriculares') // Asume que tu tabla de unidades curriculares se llama 'unidades_curriculares'
                  ->onUpdate('cascade')
                  ->onDelete('cascade')
                  ->comment('Referencia a la unidad curricular que se imparte.');

            // *** CAMBIO AQUÍ: Usamos id_trayecto como Foreign Key a tu tabla 'trayectos' ***
            $table->foreignId('id_trayecto')
                  ->constrained('trayectos') // Asume que tu tabla de trayectos se llama 'trayectos'
                  ->onUpdate('cascade')
                  ->onDelete('restrict') // Generalmente 'restrict' para trayectos, para no eliminarlos si están en uso
                  ->comment('Referencia al ID del trayecto en la tabla de trayectos.');

            // Mínimo aprobatorio para esta unidad curricular en esta malla específica.
            $table->decimal('minimo_aprobatorio', 4, 2)->nullable(false)->comment('Nota mínima para aprobar la unidad curricular en esta malla.');

            // Duración de la unidad curricular en esta malla (ej. "Trimestral", "Anual", "Por Fases").
            $table->string('duracion_en_malla', 50)->nullable(false)->comment('Duración o periodicidad de la unidad curricular en esta malla.');

            // Fase específica dentro del trayecto (ej. "Fase 1", "Fase 2"). Nulable si no aplica.
            $table->string('fase_malla', 20)->nullable()->comment('Fase de la unidad curricular dentro del trayecto (ej: Fase 1, Fase 2).');
            
            // Tipo de la unidad curricular en esta malla (ej. Obligatoria, Electiva, Requisito, etc.).
            $table->string('tipo_uc_en_malla', 50)->nullable(false)->comment('Clasificación de la unidad curricular dentro de esta malla (ej: Obligatoria, Electiva).');

            // Año de vigencia para esta entrada específica de la malla.
            $table->year('año_de_vigencia_de_entrada_malla')->nullable()->comment('Año en que esta entrada de la malla entra en vigencia (opcional).');

            // Un campo para créditos específicos en esta malla, si varían del genérico en UnidadesCurriculares.
            // Cambiado a integer, asumiendo que los créditos siempre son números enteros en tu sistema.
            $table->integer('creditos_en_malla')->nullable()->comment('Créditos asignados a la unidad curricular en esta malla específica (puede variar del valor genérico).');

            // Índice único compuesto para evitar duplicados en la malla:
            // Ahora incluye 'id_trayecto' en lugar de 'numero_trayecto'.
            $table->unique(['id_especialidad', 'id_unidad_curricular', 'id_trayecto', 'fase_malla', 'año_de_vigencia_de_entrada_malla'], 'malla_unique_uc_periodo');

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('mallas_curriculares');
    }
};