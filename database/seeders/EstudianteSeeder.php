<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; // Añadir esta línea si no está

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

        // 2. Detectar el delimitador del CSV (coma o punto y coma)
        $detectedDelimiter = ','; // Asumimos coma por defecto
        if (($handleTemp = fopen($csvFile, 'r')) !== FALSE) {
            $testLine = fgets($handleTemp);
            fclose($handleTemp);
            if (str_contains($testLine, ';')) {
                $detectedDelimiter = ';';
            }
        }
        $this->command->info('Delimitador detectado automáticamente: "' . $detectedDelimiter . '"');

        if (($handle = fopen($csvFile, 'r')) !== FALSE) {
            $this->command->info('El archivo CSV se abrió correctamente para lectura.');

            // 3. Leer el encabezado del CSV
            $header = fgetcsv($handle, 0, $detectedDelimiter);
            if ($header === FALSE || empty($header)) {
                $this->command->error('Error: No se pudo leer el encabezado del CSV o el encabezado está vacío.');
                fclose($handle);
                return;
            }
            $header = array_map(fn($h) => trim($h), $header);
            $header = array_filter($header, fn($h) => $h !== '');
            $expectedColumnCount = count($header);
            $this->command->info('Encabezado leído (limpio): ' . implode(' | ', $header) . ' (Columnas: ' . $expectedColumnCount . ')');


            // 4. Mapeo de columnas del CSV a las de la base de datos
            $columnMapping = [
                'NRO. C.I.' => 'cedula',
                'APELLIDOS Y NOMBRES' => 'apellidos_nombres',
                'CORREO' => 'email',
                'TELEFONO' => 'telefono',
                'FECHA DE NACIMIENTO' => 'fecha_nacimiento', // CONFIRMA este nombre en tu CSV
                'SEDE' => 'sede',
                'MUNICIPIO' => 'municipio',
                'PARROQUIA' => 'parroquia',
                //'STATUS_ACTIVO' => 'estatus_activo'
            ];
            $this->command->info('Mapeo de columnas configurado.');

            $dataToInsert = [];
            $rowNumber = 1;
            $rowsSkipped = 0;

            $this->command->info('Iniciando lectura de filas de datos y preparación para inserción...');

            // 5. Leer cada fila de datos del CSV
            while (($row = fgetcsv($handle, 0, $detectedDelimiter)) !== FALSE) {
                $rowNumber++;
                $insertData = [];

                $row = array_map(fn($value) => trim($value), $row);

                $filteredRow = array_filter($row, fn($value) => !is_null($value) && $value !== '');
                if (empty($filteredRow)) {
                    $this->command->warn("Saltando fila {$rowNumber}: está completamente vacía después de limpiar.");
                    $rowsSkipped++;
                    continue;
                }
                
                $currentColumnCount = count($row);
                if ($currentColumnCount > $expectedColumnCount) {
                    $row = array_slice($row, 0, $expectedColumnCount);
                    $this->command->warn("ADVERTENCIA en fila {$rowNumber}: Más columnas de las esperadas. Truncando.");
                } elseif ($currentColumnCount < $expectedColumnCount) {
                    $row = array_pad($row, $expectedColumnCount, null);
                    $this->command->warn("ADVERTENCIA en fila {$rowNumber}: Menos columnas de las esperadas. Rellenando con nulos.");
                }

                $rowData = array_combine($header, $row);

                //dd($rowData); // <-- DESCOMENTA ESTA LÍNEA AQUÍ
                // // Ejecuta el seeder. ¿Los datos de la fila se ven correctos y el array combinado tiene las claves del header?

                foreach ($columnMapping as $csvColumnName => $dbColumnName) {
                    $value = $rowData[$csvColumnName] ?? null;
                    $insertData[$dbColumnName] = ($value === '') ? null : $value;
                }

                                // AÑADE EL SIGUIENTE BLOQUE DESPUÉS DEL FOREACH ANTERIOR
                // ----- TRATAMIENTO ESPECÍFICO PARA FECHA DE NACIMIENTO -----
                if (isset($insertData['fecha_nacimiento']) && !empty($insertData['fecha_nacimiento'])) {
                    try {
                        // Intenta parsear la fecha en el formato 'D/M/YYYY' y luego formatearla a 'YYYY-MM-DD'
                        $fechaNacimiento = \DateTime::createFromFormat('d/m/Y', $insertData['fecha_nacimiento']);
                        if ($fechaNacimiento) {
                            $insertData['fecha_nacimiento'] = $fechaNacimiento->format('Y-m-d');
                        } else {
                            // Si el formato no es 'j/n/Y', intenta otro común o asigna un default
                            // Por ejemplo, si es 'YYYY-MM-DD' ya, no hace falta convertir
                            // Si es otro formato como 'DD-MM-YYYY', cambia 'j/n/Y' a 'd-m-Y'
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

                // // dd($insertData); // <-- DESCOMENTA ESTA LÍNEA AQUÍ
                // // Ejecuta el seeder. ¿Los datos están mapeados a los nombres de tus columnas de DB, con nulls o valores esperados?
                // // ¿'estatus_activo' es true/false? ¿'fecha_nacimiento' es YYYY-MM-DD?

                if ($insertData['apellidos_nombres'] === null) {
                    $insertData['apellidos_nombres'] = 'N.N. Sin Nombre';
                }
                
                if ($insertData['cedula'] === null || $insertData['cedula'] === '') {
                    $this->command->error("Saltando fila {$rowNumber}: 'NRO. C.I.' (cédula) está vacío y es requerido. Contenido: " . implode(' | ', $row));
                    $rowsSkipped++;
                    continue; 
                }

                //$insertData['estatus_activo'] = (isset($insertData['estatus_activo']) && ($insertData['estatus_activo'] === 'ACTIVO' || $insertData['estatus_activo'] === '1'));
                //$insertData['fecha_nacimiento'] = $insertData['fecha_nacimiento'] ?? '1990-01-01'; // Ejemplo de default
                

                $dataToInsert[] = $insertData;

                if (count($dataToInsert) > 0 && count($dataToInsert) % 500 === 0) {
                    $this->command->info("-> Procesados y preparados " . count($dataToInsert) . " registros.");
                }
            }
            fclose($handle);

            $this->command->info('Lectura del CSV finalizada. Total de filas leídas: ' . ($rowNumber - 1));
            $this->command->info('Filas saltadas (vacías o con error de cédula): ' . $rowsSkipped);
            $this->command->info('Total de registros preparados para insertar: ' . count($dataToInsert));

            //dd($dataToInsert); // <--- DESCOMENTA ESTA LÍNEA AQUÍ (¡Descomenta esta después de las anteriores!)
            // Esta te mostrará el array COMPLETO de todos los registros listos para la inserción en bloque.
            // Es la última oportunidad de verificar la integridad de los datos antes de la DB.

            // 6. Insertar los datos en la base de datos por bloques
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
                        break;
                    }
                }
                $this->command->info('¡Proceso de siembra de estudiantes COMPLETO!');
                $this->command->info('Total de registros insertados: ' . $totalInserted);
            }

        } else {
            $this->command->error('Error CRÍTICO: No se pudo abrir el archivo CSV. Verifique permisos o ruta.');
        }
        $this->command->info('FINALIZANDO EstudianteSeeder.');
    }
}