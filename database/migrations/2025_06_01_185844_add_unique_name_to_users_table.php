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
        Schema::table('users', function (Blueprint $table) {
            //
            //$table->unique('name'); tuve que deshabilitarlo porque se me olvido hacer php artisan migrate luego de crear este archivo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        $table->dropUnique('users_name_unique'); // El nombre del índice puede variar según tu sistema de base de datos

        });
    }
};
