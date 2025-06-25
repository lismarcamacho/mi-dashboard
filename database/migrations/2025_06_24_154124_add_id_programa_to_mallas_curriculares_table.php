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
    public function up()
    {
        Schema::table('mallas_curriculares', function (Blueprint $table) {
            // Añade la columna 'id_programa'
            // unsignedBigInteger es adecuado para IDs de clave foránea
            $table->unsignedBigInteger('id_programa')->nullable()->after('id_especialidad');

            // Define la clave foránea que referencia a la tabla 'programas'
            // Asume que tu tabla de programas se llama 'programas' y su clave primaria es 'id'
            $table->foreign('id_programa')
                  ->references('id')
                  ->on('programas')
                  ->onDelete('set null'); // O 'cascade' si prefieres eliminar mallas si se elimina el programa
                                        // 'set null' es una opción más segura para empezar,
                                        // ya que mantiene la entrada de la malla pero desvincula el programa.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mallas_curriculares', function (Blueprint $table) {
            // Elimina la clave foránea primero
            $table->dropConstrainedForeignId('id_programa'); // Laravel 8+ usa dropConstrainedForeignId
                                                            // Para versiones anteriores, usar:
                                                            // $table->dropForeign(['id_programa']);

            // Luego elimina la columna
            $table->dropColumn('id_programa');
        });
    }
};