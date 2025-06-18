<?php

namespace Database\Seeders;

use App\Models\Estudiante;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

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

        $csvFileName = 'estudiantes_para_importar.csv';
        $csvFile = Storage::path($csvFileName);
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
            $header = fgetcsv($handle, 0, $detectedDelimiter); // Usamos 0 para longitud máxima
            if ($header === FALSE || empty($header)) {
                $this->command->error('Error: No se pudo leer el encabezado del CSV o el encabezado está vacío.');
                fclose($handle);
                return;
            }
            // Limpiar encabezado: eliminar espacios extra y asegurar que no haya columnas vacías en el nombre
            $header = array_map(fn($h) => trim($h), $header);
            $header = array_filter($header, fn($h) => $h !== ''); // Eliminar columnas del encabezado si están vacías
            $expectedColumnCount = count($header); // El número de columnas esperado es el del encabezado limpio
            $this->command->info('Encabezado leído (limpio): ' . implode(' | ', $header) . ' (Columnas: ' . $expectedColumnCount . ')');


            // 4. Mapeo de columnas del CSV a las de la base de datos
            $columnMapping = [
                'NRO. C.I.' => 'cedula',
                'APELLIDOS Y NOMBRES' => 'apellidos_nombres',
                'CORREO' => 'email',
                'TELEFONO' => 'telefono',
                'FECHA DE NACIMIENTO' => 'fecha_nacimiento', // <-- ¡Añade esta línea!
                'SEDE' => 'sede',
                'MUNICIPIO' => 'municipio',
                'PARROQUIA' => 'parroquia',
                'STATUS_ACTIVO' => 'estatus_activo'
            ];

            $dataToInsert = [];
            $rowNumber = 1;
            $rowsSkipped = 0;

            $this->command->info('Iniciando lectura de filas de datos y preparación para inserción...');

            // 5. Leer cada fila de datos del CSV
            while (($row = fgetcsv($handle, 0, $detectedDelimiter)) !== FALSE) { // Usamos 0 para longitud máxima
                $rowNumber++;
                $insertData = []; // Para los datos de la fila actual

                // 5.1. Limpiar cada elemento de la fila de espacios extra
                $row = array_map(fn($value) => trim($value), $row);

                // 5.2. Saltar filas que estén completamente vacías después de limpiar
                $filteredRow = array_filter($row, fn($value) => !is_null($value) && $value !== '');
                if (empty($filteredRow)) {
                    $this->command->warn("Saltando fila {$rowNumber}: está completamente vacía después de limpiar.");
                    $rowsSkipped++;
                    continue; // Ir a la siguiente fila del CSV
                }
                
                // 5.3. Ajustar el conteo de la fila si es necesario para que coincida con el encabezado.
                // Esto es crucial para array_combine()
                $currentColumnCount = count($row);
                if ($currentColumnCount > $expectedColumnCount) {
                    // Si la fila tiene más columnas, truncar las extras
                    $row = array_slice($row, 0, $expectedColumnCount);
                    $this->command->warn("ADVERTENCIA en fila {$rowNumber}: Más columnas de las esperadas. Truncando.");
                } elseif ($currentColumnCount < $expectedColumnCount) {
                    // Si la fila tiene menos columnas, rellenar con nulos para que array_combine funcione
                    $row = array_pad($row, $expectedColumnCount, null);
                    $this->command->warn("ADVERTENCIA en fila {$rowNumber}: Menos columnas de las esperadas. Rellenando con nulos.");
                }

                // 5.4. Combinar la fila leída con el encabezado.
                // Ya no necesitamos @array_combine ni el chequeo de $rowData === false aquí,
                // ya que hemos forzado que los conteos de header y row sean iguales.
                $rowData = array_combine($header, $row);

                // 5.5. Mapear y preparar datos para la inserción, convirtiendo vacíos a null
                foreach ($columnMapping as $csvColumnName => $dbColumnName) {
                    $value = $rowData[$csvColumnName] ?? null; // Si no existe en rowData, es null
                    $insertData[$dbColumnName] = ($value === '') ? null : $value; // Convertir cadenas vacías a null
                }

                // 5.6. Manejar campos NOT NULL que pueden venir vacíos del CSV
                // 'apellidos_nombres' es NOT NULL en tu DB. Si viene null/vacío, le asignamos un valor por defecto.
                if ($insertData['apellidos_nombres'] === null) {
                    $insertData['apellidos_nombres'] = 'N.N. Sin Nombre';
                    // $this->command->warn("Fila {$rowNumber}: 'APELLIDOS Y NOMBRES' vacío. Asignado 'N.N. Sin Nombre'."); // Descomentar para depurar
                }
                
                // 'cedula' es NOT NULL en tu DB. Si viene null/vacío, salta esta fila.
                if ($insertData['cedula'] === null || $insertData['cedula'] === '') {
                    $this->command->error("Saltando fila {$rowNumber}: 'NRO. C.I.' (cédula) está vacío y es requerido. Contenido: " . implode(' | ', $row));
                    $rowsSkipped++;
                    continue; 
                }

                // 5.7. Transformaciones y valores por defecto para otros campos de la DB
                // Asegúrate de que los campos 'genero', 'nacionalidad', 'email_institucional', 'telefono_fijo', 'direccion'
                // estén definidos como NULLABLE en tu migración si pueden venir vacíos.
                // Si son NOT NULL, deberías asignar un valor por defecto aquí si vienen vacíos.
                $insertData['estatus_activo'] = (isset($insertData['estatus_activo']) && ($insertData['estatus_activo'] === 'ACTIVO' || $insertData['estatus_activo'] === '1'));
                $insertData['fecha_nacimiento'] = $insertData['fecha_nacimiento'] ?? '1990-01-01'; // Ejemplo de default
                

                // 5.8. Agregar la fila preparada al array de inserción
                $dataToInsert[] = $insertData;

                // Información de progreso cada 500 registros
                if (count($dataToInsert) > 0 && count($dataToInsert) % 500 === 0) {
                    $this->command->info("-> Procesados y preparados " . count($dataToInsert) . " registros.");
                }
            }
            fclose($handle);

            $this->command->info('Lectura del CSV finalizada. Total de filas leídas: ' . ($rowNumber - 1));
            $this->command->info('Filas saltadas (vacías o con error de cédula): ' . $rowsSkipped);
            $this->command->info('Total de registros preparados para insertar: ' . count($dataToInsert));

            // 6. Insertar los datos en la base de datos por bloques
            if (empty($dataToInsert)) {
                $this->command->error('¡ATENCIÓN! No hay registros válidos para insertar.');
            } else {
                $chunkSize = 500;
                $totalInserted = 0;
                $this->command->info('Iniciando inserción en la base de datos...');

                foreach (array_chunk($dataToInsert, $chunkSize) as $chunk) {
                    try {
                        Estudiante::insert($chunk);
                        $totalInserted += count($chunk);
                        // $this->command->info("-> Insertados " . $totalInserted . " registros."); // Descomentar para más detalles
                    } catch (\Exception $e) {
                        $errorMessage = $e->getMessage();
                        $this->command->error("Error SQL durante la inserción: " . $errorMessage);

                        // Intenta mostrar el primer registro del bloque que causó el error para depuración
                        $this->command->warn("Primer registro del bloque con error: " . json_encode($chunk[0]));
                        $this->command->warn("Deteniendo inserción. Revise los datos y restricciones de la DB (NULL, UNIQUE, etc.).");
                        break; // Detener el proceso en el primer error SQL
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