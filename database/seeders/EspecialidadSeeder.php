<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('especialidades')->insert([
            [
                'codigo_especialidad' => 'ESP001',
                'nombre_especialidad' => 'Contaduria Publica',
                'duracion' => '5 años',
                'descripcion' => 'Descripción de Contaduría Pública'
            ],
            [
                'codigo_especialidad' => 'ESP002',
                'nombre_especialidad' => 'Ingenieria en Mantenimiento',
                'duracion' => '5 años',
                'descripcion' => 'Descripción de Ingeniería en Mantenimiento'
            ],
            [
                'codigo_especialidad' => 'ESP003',
                'nombre_especialidad' => 'Ingenieria en Electricidad',
                'duracion' => '5 años',
                'descripcion' => 'Descripción de Ingeniería en Electricidad'
            ],
            [
                'codigo_especialidad' => 'ESP004',
                'nombre_especialidad' => 'Administracion',
                'duracion' => '4 años',
                'descripcion' => 'Descripción de Administración'
            ],
            // ... más especialidades
        ]);



    }
}
