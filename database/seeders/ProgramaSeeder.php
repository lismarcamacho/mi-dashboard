<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon; // Importa Carbon para las fechas
use App\Models\Programa;
use App\Models\Especialidad; // ¡Importa la Especialidad para obtener IDs!

class ProgramaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void

    {
        // Obtén algunas especialidades existentes para asignarlas
        $especialidadMantenimiento = Especialidad::where('nombre_especialidad', 'Ingeniería en Mantenimiento')->first();
        $especialidadElectricidad = Especialidad::where('nombre_especialidad', 'Ingeniería en Electricidad')->first();
        $especialidadAdministracion = Especialidad::where('nombre_especialidad', 'Administración')->first();
        $especialidadContaduria = Especialidad::where('nombre_especialidad', 'Contaduría Pública')->first();

        if (!$especialidadMantenimiento) {
            $this->command->warn('Especialidad "Ingeniería en Mantenimiento" no encontrada. Verifique EspecialidadSeeder.');
        }
        if (!$especialidadElectricidad) {
            $this->command->warn('Especialidad "Ingeniería en Electricidad" no encontrada. Verifique EspecialidadSeeder.');
        }
        if (!$especialidadAdministracion) {
            $this->command->warn('Especialidad "Administración" no encontrada. Verifique EspecialidadSeeder.');
        }
        if (!$especialidadContaduria) {
            $this->command->warn('Especialidad "Contaduría Pública" no encontrada. Verifique EspecialidadSeeder.');
        }

        $programasData = [
            [
                'nombre_programa' => 'Programa Nacional de Formación de Contaduría Pública', // Corregido: 'nombre'
                'codigo_programa' => '01003', // Añadido: un código único
                'descripcion' => 'Formación de profesionales en contaduría pública.', // Añadido: descripción
                'created_at' => Carbon::now(), // Añadido: fecha de creación
                'updated_at' => Carbon::now(), // Añadido: fecha de actualización

            ],
            [
                'nombre_programa' => 'Programa Nacional de Formación de Ingeniería en Mantenimiento',
                'codigo_programa' => '01007',
                'descripcion' => 'Formación de profesionales en mantenimiento industrial.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'nombre_programa' => 'Programa Nacional de Formación de Ingeniería en Electricidad',
                'codigo_programa' => '01004',
                'descripcion' => 'Formación de profesionales en ingeniería eléctrica.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'nombre_programa' => 'Programa Nacional de Formación de Administración',
                'codigo_programa' => '01001',
                'descripcion' => 'Formación de profesionales en administración de empresas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'nombre_programa' => 'Programa Especial de Recuperación',
                'codigo_programa' => 'PER',
                'descripcion' => 'Programa para la recuperación académica de estudiantes.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            [
                'nombre_programa' => 'Programa de Iniciación Universitaria',
                'codigo_programa' => 'PIU',
                'descripcion' => 'Programa introductorio para nuevos ingresos a la universidad.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ],
            // ... puedes agregar más programas aquí
        ];
        // Usamos un array para almacenar las asociaciones programa -> especialidad_id
        // Esto es para que después de crear el programa, podamos adjuntarle la especialidad.
        $programasConAsociaciones = [
            'Programa Nacional de Formación de Contaduría Pública' => $especialidadContaduria,
            'Programa Nacional de Formación de Ingeniería en Mantenimiento' => $especialidadMantenimiento,
            'Programa Nacional de Formación de Ingeniería en Electricidad' => $especialidadElectricidad,
            'Programa Nacional de Formación de Administración' => $especialidadAdministracion,
            // Los programas "Especial de Recuperación" y "Iniciación Universitaria"
            // si no tienen una especialidad específica asociada en tu diseño,
            // simplemente no los incluyas aquí o maneja su asociación de otra forma.
            // Si pueden tener CUALQUIER especialidad, podrías asociarlos a una genérica o dejar sin asociación.
            // Para el ejemplo, los dejo sin especialidad si son null.
            'Programa Especial de Recuperación' => null, // No se adjuntará especialidad si es null
            'Programa de Iniciación Universitaria' => null, // No se adjuntará especialidad si es null
        ];


        foreach ($programasData as $data) {
            // Crea o encuentra el programa para evitar duplicados si se ejecuta el seeder varias veces 
            $programa = Programa::firstOrCreate(
                ['codigo_programa' => $data['codigo_programa']], // Criterio de búsqueda (idealmente único)
                array_merge($data, [ // Asegurarse de que created_at/updated_at estén aquí si no son fillable
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ])
            );

            // Ahora, si hay una especialidad asociada a este programa, la adjuntamos
            if (isset($programasConAsociaciones[$data['nombre_programa']]) && $programasConAsociaciones[$data['nombre_programa']] !== null) {
                $especialidadAAsociar = $programasConAsociaciones[$data['nombre_programa']];

                // Adjunta la especialidad al programa (agrega una entrada en la tabla pivote)
                // Usamos syncWithoutDetaching para agregarla solo si no está ya adjunta
                $programa->especialidades()->syncWithoutDetaching([$especialidadAAsociar->id]);
                // O si quieres adjuntar múltiples: $programa->especialidades()->attach($especialidadAAsociar->id);
            }
        }
    }
}
