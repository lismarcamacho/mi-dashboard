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
        Schema::create('unidad_curriculars', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',70)->nullable(false);
            $table->string('uc',2)->nullable(false);
            $table->string('hrs_sem',2)->nullable(false);
            $table->string('hta',3)->nullable(false);
            $table->string('hti',3)->nullable(false);
            $table->string('hte',4)->nullable(false);
            $table->string('dist',4)->nullable(false);
            $table->string('fase',4)->nullable(false);           
            $table->string('eje',15)->nullable(false);
            $table->dateTime('fecha_pnf')->nullable(false);
            $table->string('min_aprobatorio')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidad_curriculars');
    }
};
