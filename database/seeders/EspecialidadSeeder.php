<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Especialidad; // Asegúrate de la ruta correcta

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Deshabilita las comprobaciones de clave foránea si es necesario (ya las tienes en DatabaseSeeder, pero es buena práctica mencionarlo)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Define tus especialidades con todos los campos requeridos
        $especialidadesData = [
            [
                'codigo_especialidad' => 'PNFCP',
                'nombre_especialidad' => 'Contaduria Publica',
                'duracion' => '5 años',
                'descripcion' => 'Formación integral en principios contables y financieros.'
            ],
            [
                'codigo_especialidad' => 'PNFM',
                'nombre_especialidad' => 'Ingenieria en Mantenimiento',
                'duracion' => '5 años',
                'descripcion' => 'Diseño y gestión de sistemas de mantenimiento industrial.'
            ],
            [
                'codigo_especialidad' => 'PNFIE',
                'nombre_especialidad' => 'Ingenieria en Electricidad',
                'duracion' => '5 años',
                'descripcion' => 'Desarrollo e implementación de sistemas eléctricos.'
            ],
            [
                'codigo_especialidad' => 'PNFA',
                'nombre_especialidad' => 'Administracion',
                'duracion' => '5 años',
                'descripcion' => 'Gestión y optimización de recursos empresariales.'
            ],
            // Agrega más especialidades aquí con todos sus datos
            // [
            //     'codigo_especialidad' => '0100X',
            //     'nombre_especialidad' => 'Nueva Especialidad',
            //     'duracion' => 'X años',
            //     'descripcion' => 'Descripción de la nueva especialidad.'
            // ],
        ];

        // 3. Itera sobre los datos y usa firstOrCreate para insertar o encontrar
        foreach ($especialidadesData as $data) {
            Especialidad::firstOrCreate(
                // Criterio para encontrar (usualmente una o más columnas únicas)
                // Usamos 'nombre_especialidad' como criterio principal para uniqueness
                ['nombre_especialidad' => $data['nombre_especialidad']],
                // Datos completos para crear si no existe
                $data
            );
        }

        // 4. Vuelve a habilitar las comprobaciones de clave foránea si las deshabilitaste aquí
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}