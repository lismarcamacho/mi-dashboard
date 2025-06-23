<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Programa; 
use App\Models\Trayecto; 

class TrayectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opcional: Deshabilitar las comprobaciones de clave foránea
        // Si ya lo haces en DatabaseSeeder, no es necesario aquí.
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Obtener un programa existente para asociar los trayectos
        // Opción 1: Obtener el primer programa que encuentres (útil si solo tienes uno o no importa cuál)
        $programa1 = Programa::first();

        // Opción 2: Obtener un programa por un atributo específico, por ejemplo, su nombre
        // Asegúrate de que este programa exista en tu base de datos (creado por ProgramaSeeder)
        $programa_mantenimiento = Programa::where('nombre_programa', 'Ingeniería de Mantenimiento')->first();
        $programa_administracion = Programa::where('nombre_programa', 'Administración')->first();
        $programa_contaduria = Programa::where('nombre_programa', 'Contaduría Pública')->first();
        $programa_electricidad = Programa::where('nombre_programa', 'Ingeniería en Electricidad')->first();




        // Crear trayectos y asociarlos a los programas
        // Utiliza firstOrCreate para evitar duplicados si el seeder se ejecuta varias veces
        if ($programa_mantenimiento) {
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto 0',
                'programa_id' => $programa_mantenimiento->id,
                ],
                [
                'numero_orden' => 0,
                'descripcion' => 'Trayecto introductorio del Programa PIU',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto I',
                'programa_id' => $programa_mantenimiento->id,
                ],
                [
                'numero_orden' => 1,
                'descripcion' => 'TI',
                ]

        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto II',
                'programa_id' => $programa_mantenimiento->id,
                ],
                [
                'numero_orden' => 2,
                'descripcion' => 'TII',
                ]

        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto III',
                'programa_id' => $programa_mantenimiento->id,
                ],
                [
                'numero_orden' => 3,
                'descripcion' => 'TIII',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto IV',
                'programa_id' => $programa_mantenimiento->id,
                ],
                [
                'numero_orden' => 4,
                'descripcion' => 'TIV',
                ]
        );
        } else {
            $this->command->info('Programa "Ingeniería de Mantenimiento" no encontrado. No se crearon trayectos para él.');
        }

        if ($programa_administracion) {
              Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto 0',
                'programa_id' => $programa_administracion->id,
                ],
                [
                'numero_orden' => 0,
                'descripcion' => 'Trayecto introductorio del Programa PIU',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto I',
                'programa_id' => $programa_administracion->id,
                ],
                [
                'numero_orden' => 1,
                'descripcion' => 'TI',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto II',
                'programa_id' => $programa_administracion->id,
                 ],
                [
                'numero_orden' => 2,
                'descripcion' => 'TII',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto III',
                'programa_id' => $programa_administracion->id,
                ],
                [
                'numero_orden' => 3,
                'descripcion' => 'TIII',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto IV',
                'programa_id' => $programa_administracion->id,
                ],
                [
                'numero_orden' => 4,
                'descripcion' => 'TIV',
                ]
        );
        } else {
            $this->command->info('Programa "Administración" no encontrado. No se crearon trayectos para él.');
        }

        if ($programa_contaduria) {
                Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto 0',
                'programa_id' => $programa_contaduria->id,
                ],
                [
                'numero_orden' => 0,
                'descripcion' => 'Trayecto Introductorio del Programa PIU',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto I',
                'programa_id' => $programa_contaduria->id,
                ],
                [
                'numero_orden' => 1,
                'descripcion' => 'TI',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto II',
                'programa_id' => $programa_contaduria->id,
                ],
                 [
                'numero_orden' => 2,
                'descripcion' => 'TII',
                ]

        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto III',
                'programa_id' => $programa_contaduria->id,
                ],
                 [
                'numero_orden' => 3,
                'descripcion' => 'TIII',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto IV',
                'programa_id' => $programa_contaduria->id,
                ],
                 [
                'numero_orden' => 4,
                'descripcion' => 'TIV',
                ]
        );
        } else {
            $this->command->info('Programa "Contaduria Publica" no encontrado. No se crearon trayectos para él.');
        }

        if ($programa_electricidad) {
                Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto 0',
                'programa_id' => $programa_electricidad->id,
                ],
                [
                'numero_orden' => 0,
                'descripcion' => 'Trayecto Introductorio del Programa PIU',
                ]
        );

        
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto I',
                'programa_id' => $programa_electricidad->id,
                ],
                [
                'numero_orden' => 1,
                'descripcion' => 'TI',
                ]
        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto II',
                'programa_id' => $programa_electricidad->id,
                ],
                [
                'numero_orden' => 2,
                'descripcion' => 'TII',
                ]

        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto III',
                'programa_id' => $programa_electricidad->id,
                ],
                [
                'numero_orden' => 3,
                'descripcion' => 'TIII',
                ]

        );
            Trayecto::firstOrCreate(
                [
                'nombre_trayecto' => 'Trayecto IV',
                'programa_id' => $programa_electricidad->id,
                ],
                [
                'numero_orden' => 4,
                'descripcion' => 'TIV',
                ]
        );
        } else {
            $this->command->info('Programa "Ingenieria en Electricidad" no encontrado. No se crearon trayectos para él.');
        }



        // También puedes usar el programa genérico si no te importa el específico
        if ($programa1) {
             Trayecto::firstOrCreate([
                'nombre_trayecto' => 'Trayecto Único',
                'programa_id' => $programa1->id,
            ]);
        }


        // Opcional: Volver a habilitar las comprobaciones de clave foránea
        // Si ya lo haces en DatabaseSeeder, no es necesario aquí.
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
