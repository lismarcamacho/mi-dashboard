<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
            DB::table('titulos')->insert([
            ['nombre_titulo' => 'Asistente Contable'],
            ['nombre_titulo' => 'Tsu en  Contaduria Publica'],
            ['nombre_titulo' => 'Licenciado en  Contaduria Publica'],
            ['nombre_titulo' => 'Ingeniero de Mantenimiento'],           
            ['nombre_titulo' => 'Ingeniero en Electricidad'],    
            // ... más especialidades
        ]);
    }
}
