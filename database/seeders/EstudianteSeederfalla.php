<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Añadir esta línea si no está
// >>>>> AÑADE ESTAS DOS LÍNEAS <<<<<
use League\Csv\Reader;
use League\Csv\Exception;
// >>>>> FIN DE LAS LÍNEAS A AÑADIR <<<<<


class EstudianteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('INICIANDO EstudianteSeeder (VERSION ULTRA ROBUSTA PARA CSV).');

        // 1. Limpiar la tabla de estudiantes antes de insertar
        Estudiante::truncate();
        $this->command->info('Tabla de estudiantes truncada.');

        // ¡ATENCIÓN A ESTO!
        // Si tu CSV se llama 'estudiantes_para_importar_corregido.csv'
        // pero aquí tienes 'estudiantes_para_importar.csv', CÁMBIALO:
        $csvFileName = 'estudiantes_para_importar.csv'; // <-- ¡VERIFICA ESTE NOMBRE!
        // También, si tu archivo no está en 'storage/app/', ajusta el path:
        // Por ejemplo, si está en 'storage/app/public/':
        $csvFile = Storage::path($csvFileName); // Asegúrate de que esta ruta sea correcta
        // O si está en la raíz de storage/app:
        // $csvFile = Storage::path($csvFileName);

        $this->command->info('Ruta del archivo CSV: ' . $csvFile);

        if (!file_exists($csvFile)) {
            $this->command->error('Error: El archivo CSV NO SE ENCONTRÓ en la ruta esperada: ' . $csvFile);
            return;
        }

                // >>>>> INICIO DEL CÓDIGO A INSERTAR/REEMPLAZAR <<<<<
        // Esta sección reemplaza toda la lógica anterior de fopen, fgetcsv y detección de delimitador.
        try {
            // 1. Crear una instancia de Reader
            $csv = Reader::createFromPath($csvFile, 'r');

            // 2. Establecer el delimitador y la codificación de forma explícita
            $csv->setDelimiter(';'); // <--- ¡IMPORTANTE! Confirma si tu CSV usa coma ',' o punto y coma ';'
            $csv->setHeaderOffset(0); // Tu CSV tiene encabezados en la primera fila
            $csv->skipEmptyRecords(); // Saltar filas completamente vacías

            // AÑADIR ESTA LÍNEA CLAVE PARA FORZAR LA CODIFICACIÓN UTF-8 AL LEER
            $csv->setEncodingFrom('UTF-8'); // Indica que el archivo de origen YA es UTF-8

            $this->command->info('Lectura del CSV con League\Csv finalizada.');

            // Obtener el encabezado
            $header = $csv->getHeader();
            $this->command->info('Encabezado del CSV (leído por League\Csv): ' . implode(' | ', $header));

            // 3. Mapeo de columnas del CSV a las de la base de datos
            $columnMapping = [
                'NRO. C.I.' => 'cedula',
                'APELLIDOS Y NOMBRES' => 'apellidos_nombres',
                'CORREO' => 'email',
                'TELEFONO' => 'telefono',
                'FECHA DE NACIMIENTO' => 'fecha_nacimiento', // CONFIRMA este nombre en tu CSV
                'SEDE' => 'sede',
                'MUNICIPIO' => 'municipio',
                'PARROQUIA' => 'parroquia',
                'STATUS_ACTIVO' => 'estatus_activo'
            ];
            $this->command->info('Mapeo de columnas configurado.');

            $dataToInsert = [];
            $rowsSkipped = 0;
            $rowNumber = 1; // Para llevar la cuenta de la fila original en el CSV (excluyendo encabezado)

            $this->command->info('Iniciando lectura de filas de datos y preparación para inserción...');

            // 4. Leer cada fila de datos del CSV usando los records de League\Csv
            foreach ($csv->getRecords() as $offset => $record) {
                $rowNumber = $offset + 2; // +1 por el offset base 0, +1 por el encabezado
                $insertData = [];

                // Verificar que las claves del mapeo existan en el record
                foreach ($columnMapping as $csvColumnName => $dbColumnName) {
                    $value = $record[$csvColumnName] ?? null;
                    $insertData[$dbColumnName] = ($value === '') ? null : $value;
                }

                // ----- TRATAMIENTO ESPECÍFICO PARA FECHA DE NACIMIENTO -----
                if (isset($insertData['fecha_nacimiento']) && !empty($insertData['fecha_nacimiento'])) {
                    try {
                        // Intenta parsear la fecha en el formato 'D/M/YYYY' y luego formatearla a 'YYYY-MM-DD'
                        $fechaNacimiento = \DateTime::createFromFormat('d/m/Y', $insertData['fecha_nacimiento']);
                        if ($fechaNacimiento) {
                            $insertData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
                        } else {
                            // Si el formato no es 'd/m/Y', intenta otros o asigna un default
                            $this->command->warn("Fila {$rowNumber}: Formato de fecha de nacimiento inválido ('{$insertData['fecha_nacimiento']}'). Usando valor por defecto '1990-01-01'.");
                            $insertData['fecha_nacimiento'] = '1990-01-01'; // Asigna un valor por defecto si falla
                        }
                    } catch (\Exception $e) {
                        $this->command->error("Fila {$rowNumber}: Error al procesar fecha de nacimiento '{$insertData['fecha_nacimiento']}': " . $e->getMessage());
                        $insertData['fecha_nacimiento'] = '1990-01-01'; // Asigna un valor por defecto en caso de error
                    }
                } else {
                    $insertData['fecha_nacimiento'] = '1990-01-01'; // Asigna un valor por defecto si está vacío o nulo
                }

                if ($insertData['apellidos_nombres'] === null) {
                    $insertData['apellidos_nombres'] = 'N.N. Sin Nombre';
                }

                if ($insertData['cedula'] === null || $insertData['cedula'] === '') {
                    $this->command->error("Saltando fila {$rowNumber}: 'NRO. C.I.' (cédula) está vacío y es requerido. Contenido: " . json_encode($record));
                    $rowsSkipped++;
                    continue;
                }

                $insertData['estatus_activo'] = (isset($insertData['estatus_activo']) && ($insertData['estatus_activo'] === 'ACTIVO' || $insertData['estatus_activo'] === '1'));

                $dataToInsert[] = $insertData;

                if (count($dataToInsert) > 0 && count($dataToInsert) % 500 === 0) {
                    $this->command->info("-> Procesados y preparados " . count($dataToInsert) . " registros.");
                }
            }

            $this->command->info('Lectura del CSV finalizada. Total de filas leídas: ' . ($rowNumber -1)); // -1 por el encabezado
            $this->command->info('Filas saltadas (vacías o con error de cédula): ' . $rowsSkipped);
            $this->command->info('Total de registros preparados para insertar: ' . count($dataToInsert));

            // 5. Insertar los datos en la base de datos por bloques
            if (empty($dataToInsert)) {
                $this->command->error('¡ATENCIÓN! No hay registros válidos para insertar.');
            } else {
                $chunkSize = 500;
                $totalInserted = 0;
                $this->command->info('Iniciando inserción en la base de datos...');

                foreach (array_chunk($dataToInsert, $chunkSize) as $chunk) {
                    try {
                        Estudiante::insert($chunk); // Esto inserta el bloque de datos
                        $totalInserted += count($chunk);
                    } catch (\Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->command->error("Error SQL durante la inserción: " . $errorMessage);

                        $this->command->warn("Primer registro del bloque con error: " . json_encode($chunk[0]));
                        $this->command->warn("Deteniendo inserción. Revise los datos y restricciones de la DB (NULL, UNIQUE, etc.).");
                        break; // Detener el loop en el primer error
                    }
                }
                $this->command->info('¡Proceso de siembra de estudiantes COMPLETO!');
                $this->command->info('Total de registros insertados: ' . $totalInserted);
            }

        } catch (Exception $e) { // Captura excepciones específicas de League\Csv
            $this->command->error("Error al procesar el archivo CSV: " . $e->getMessage());
            // Considera añadir un dd($e->getTraceAsString()); para más detalles
        } catch (\Exception $e) { // Captura cualquier otra excepción general
            $this->command->error("Error inesperado durante la siembra: " . $e->getMessage());
        }
        // >>>>> FIN DEL CÓDIGO A INSERTAR/REEMPLAZAR <<<<<

        $this->command->info('FINALIZANDO EstudianteSeeder.');

    }
}