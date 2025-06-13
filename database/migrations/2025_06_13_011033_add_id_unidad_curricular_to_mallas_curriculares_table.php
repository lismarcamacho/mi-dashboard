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
                Schema::table('mallas_curriculares', function (Blueprint $table) {
                    // Hacemos la columna nullable para que la migración se ejecute
                    // si ya tienes datos en 'mallas_curriculares' y no hay un id_unidad_curricular para ellos.
                    // ¡Importante!: Después de ejecutar la migración, si tienes datos antiguos,
                    // DEBERÁS ASIGNAR MANUALMENTE UN ID DE UNIDAD CURRICULAR VÁLIDO a esas filas
                    // en tu base de datos (phpMyAdmin, etc.).
                    $table->foreignId('id_unidad_curricular')
                          ->nullable() // Permite valores nulos inicialmente
                          ->constrained('unidades_curriculares')
                          ->onUpdate('cascade')
                          ->onDelete('cascade')
                          ->after('id_especialidad') // Ajusta la posición si lo deseas
                          ->comment('Referencia a la unidad curricular.');
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down(): void
            {
                Schema::table('mallas_curriculares', function (Blueprint $table) {
                    $table->dropConstrainedForeignId('id_unidad_curricular');
                });
            }
        };