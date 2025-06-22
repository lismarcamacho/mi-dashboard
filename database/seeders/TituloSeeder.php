<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Especialidad; // Asegúrate de que esta sea la ruta correcta a tu modelo Especialidad
use App\Models\Titulo;       // Si usas el modelo Titulo, asegúrate de importarlo también

class TituloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Opcional: Deshabilitar las comprobaciones de clave foránea si es necesario
        // (Aunque para insert, suele ser el orden la clave, pero por si acaso)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Obtener especialidades existentes
        // ES MUY IMPORTANTE que tu EspecialidadSeeder ya se haya ejecutado (o se ejecute antes).
        $contaduria = Especialidad::where('nombre_especialidad', 'Contaduría Pública')->first(); // Busca la especialidad por nombre
        $administracion = Especialidad::where('nombre_especialidad', 'Administración')->first();
        $mantenimiento = Especialidad::where('nombre_especialidad', 'Ingenieria en Mantenimiento')->first();
        $electricidad = Especialidad::where('nombre_especialidad', 'Ingenieria en Electricidad')->first();

        // Si las especialidades no existen, esto podría causar problemas.
        // Puedes agregar una verificación o un mensaje de error si no se encuentran.
        if (!$contaduria) {
            $this->command->info('Especialidad "Contaduría Pública" no encontrada. Asegúrate de ejecutar EspecialidadSeeder primero.');
            // Puedes retornar o lanzar una excepción si esto es crítico
        }
        // Repite para las otras especialidades

        // Array de títulos con su especialidad_id
        $titulosData = [
            [
                'nombre' => 'Asistente Contable',
                'duracion' => 'Trayecto I',
                'especialidad_id' => $contaduria ? $contaduria->id : null, // Asigna el ID si se encontró
            ],
            [
                'nombre' => 'Tsu en Contaduria Publica',
                'duracion' => 'Trayecto II',
                'especialidad_id' => $contaduria ? $contaduria->id : null,
            ],
            [
                'nombre' => 'Licenciado en Contaduria Publica',
                'duracion' => 'Trayecto IV',
                'especialidad_id' => $contaduria ? $contaduria->id : null,
            ],
            [
                'nombre' => 'Asistente Administrativo',
                'duracion' => 'Trayecto I',
                'especialidad_id' => $administracion ? $administracion->id : null,
            ],
            [
                'nombre' => 'Tsu en Administración',
                'duracion' => 'Trayecto II',
                'especialidad_id' => $administracion ? $administracion->id : null,
            ],
            [
                'nombre' => 'Licenciado en Administración',
                'duracion' => 'Trayecto IV',
                'especialidad_id' => $administracion ? $administracion->id : null,
            ],
            [
                'nombre' => 'Ingeniero de Mantenimiento',
                'duracion' => 'Trayecto IV',
                'especialidad_id' => $mantenimiento ? $mantenimiento->id : null,
            ],
            [
                'nombre' => 'Ingeniero en Electricidad',
                'duracion' => 'Trayecto IV',
                'especialidad_id' => $electricidad ? $electricidad->id : null,
            ],
        ];

        // Recorre el array e inserta cada título, usando firstOrCreate para evitar duplicados
        foreach ($titulosData as $data) {
            // Verifica que el especialidad_id no sea nulo antes de intentar insertar
            if ($data['especialidad_id'] !== null) {
                // Puedes usar el Modelo Titulo si lo tienes
                Titulo::firstOrCreate(
                    ['nombre' => $data['nombre']], // Criterio para encontrar el registro existente
                    $data                          // Datos para crear si no existe
                );
            } else {
                $this->command->warn('No se pudo insertar el título "' . $data['nombre'] . '" porque la especialidad_id es nula.');
            }
        }


        // Si usas DB::table()->insert(), ten cuidado con los duplicados.
        // Si el seeder se ejecuta varias veces, creará duplicados
        // A menos que uses truncate() antes, lo cual requiere el manejo de FKs
        // DB::table('titulos')->insert($titulosData);

        // Opcional: Volver a habilitar las comprobaciones de clave foránea
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
