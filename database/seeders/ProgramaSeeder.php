<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

            DB::table('programas')->insert([
            ['nombre_programa' => 'Programa Nacional de Formaciónn de Contaduria Publica'],
            ['nombre_programa' => 'Programa Nacional de Formaciónn de Ingenieria en Mantenimiento'],
            ['nombre_programa' => 'Programa Nacional de Formaciónn de Ingenieria en Electricidad'],
            ['nombre_programa' => 'Programa Nacional de Formaciónn de Administración'],
            ['nombre_programa' => 'Programa Especial de Recuperación'],
            ['nombre_programa' => 'Programa de Iniciación Universitaria'],
            // ... más especialidades
        ]);
    }
}
