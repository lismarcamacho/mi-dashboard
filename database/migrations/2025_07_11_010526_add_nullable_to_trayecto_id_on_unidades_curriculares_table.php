<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_add_nullable_to_trayecto_id_on_unidades_curriculares_table.php

public function up()
{
    Schema::table('unidades_curriculares', function (Blueprint $table) {
        $table->unsignedBigInteger('trayecto_id')->nullable()->change(); // Usa ->change() para modificar
    });
}

public function down()
{
    Schema::table('unidades_curriculares', function (Blueprint $table) {
        // Si quieres revertir, deberás saber el tipo original (BigInteger)
        $table->unsignedBigInteger('trayecto_id')->nullable(false)->change();
    });
}
};
