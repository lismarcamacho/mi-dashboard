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
        Schema::create('unidades_curriculares', function (Blueprint $table) {
            $table->id();
            
            // Nombre de la unidad curricular: Obligatorio, longitud razonable.
            $table->string('nombre', 255)->nullable(false)->comment('Nombre completo de la unidad curricular.');

            // Código de la unidad curricular: Obligatorio, único para evitar duplicados.
            // Asegúrate de que 70 caracteres sean suficientes para todos los códigos posibles.
            $table->string('codigo', 70)->unique()->nullable(false)->comment('Código único de la unidad curricular (ej: CALC101).');
            
            // Unidades de crédito: Decimal para permitir valores como 3.5.
            // Es un atributo intrínseco de la UC, no de la malla.
            $table->decimal('creditos', 3, 1)->nullable(false)->comment('Unidades de crédito de la unidad curricular.');

            // Horas semanales: Tipo INT, ya que son números enteros.
            // Representan la carga total semanal de contacto, o un resumen.
            $table->integer('horas_semanales')->nullable()->comment('Total de horas de contacto semanales de la unidad curricular.');

            // Horas de trabajo asistidas (teóricas/clase): Tipo INT.
            $table->integer('horas_trabajo_asistidas')->nullable()->comment('Horas semanales teóricas o de trabajo asistido en aula.');

            // Horas de trabajo independiente: Tipo INT.
            $table->integer('horas_trabajo_independiente')->nullable()->comment('Horas semanales de trabajo autónomo/independiente del estudiante.');

            // Horas de trabajo estudiantil (ej. prácticas, laboratorio, tutorías): Tipo INT.
            // Puedes renombrar esto para ser más específico si representa solo laboratorio o prácticas.
            $table->integer('horas_trabajo_estudiantil')->nullable()->comment('Horas semanales dedicadas a prácticas, laboratorio o actividades estudiantiles.');
            
            // Eje: Si es una propiedad intrínseca de la UC (ej. Eje de Formación General).
            // Si el eje varía por malla, debería ir en MallaCurricular. Asumo que es fijo por UC aquí.
            $table->string('eje', 50)->nullable()->comment('Eje de formación al que pertenece la unidad curricular (ej: Humanístico, Profesional).');

            // La descripción es opcional, pero útil para detallar el contenido.
            $table->text('descripcion')->nullable()->comment('Descripción detallada del contenido de la unidad curricular.');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_curriculares');
    }
};
