<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Proveedor;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\TipoServicio;
use App\Models\Ubicacion;
use App\Models\Disponibilidad;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ScraperSyncJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scraper:sync-json {--file=n8n_scraper.json} {--delete} {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sincroniza datos del scraper JSON con la base de datos automáticamente';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Iniciando sincronización del scraper...');
        $this->newLine();

        // Obtener opciones
        $jsonFile = $this->option('file');
        $shouldDelete = $this->option('delete');
        $dryRun = $this->option('dry-run');

        // Buscar archivo JSON
        $filePath = $this->findJsonFile($jsonFile);

        if (!$filePath) {
            $this->error("❌ No se encontró archivo JSON: $jsonFile");
            return 1;
        }

        $this->info("✓ Archivo encontrado: $filePath");
        $this->newLine();

        try {
            // Leer y parsear JSON
            $this->info('📖 Leyendo archivo JSON...');
            $data = $this->parseJson($filePath);

            if (empty($data)) {
                $this->error('❌ El JSON está vacío o no es válido');
                return 1;
            }

            $this->info("✓ Se encontraron " . count($data) . " registros");
            $this->newLine();

            // Estadísticas
            $stats = [
                'proveedores_creados' => 0,
                'proveedores_actualizados' => 0,
                'servicios_creados' => 0,
                'servicios_actualizados' => 0,
                'tarifas_creadas' => 0,
                'tarifas_actualizadas' => 0,
                'disponibilidades_creadas' => 0,
                'proveedores_eliminados' => 0,
                'servicios_eliminados' => 0,
                'tarifas_eliminadas' => 0,
            ];

            // Procesar cada registro
            $procesadosIds = [
                'proveedores' => [],
                'servicios' => [],
                'tarifas' => [],
            ];

            $totalRecords = count($data);
            $currentIndex = 0;

            foreach ($data as $index => $record) {
                $currentIndex++;
                $this->line("📊 Procesando registro $currentIndex/$totalRecords...");

                try {
                    // Sincronizar proveedor
                    $proveedor = $this->syncProveedor($record, $stats, $dryRun);
                    if ($proveedor) {
                        $procesadosIds['proveedores'][] = $proveedor->id;
                    }

                    // Sincronizar servicio
                    $servicio = $this->syncServicio($record, $proveedor, $stats, $dryRun);
                    if ($servicio) {
                        $procesadosIds['servicios'][] = $servicio->id;
                    }

                    // Sincronizar tarifa
                    $tarifa = $this->syncTarifa($record, $servicio, $stats, $dryRun);
                    if ($tarifa) {
                        $procesadosIds['tarifas'][] = $tarifa->id;
                    }

                    // Sincronizar disponibilidad
                    if ($servicio && $tarifa) {
                        $this->syncDisponibilidad($record, $tarifa, $stats, $dryRun);
                    }

                } catch (\Exception $e) {
                    $this->warn("⚠️  Error procesando registro $currentIndex: " . $e->getMessage());
                    Log::error("Scraper sync error en registro $currentIndex", [
                        'error' => $e->getMessage(),
                        'data' => $record
                    ]);
                }

                $this->newLine();
            }

            // Eliminar registros no procesados
            if ($shouldDelete) {
                $this->info('🗑️  Eliminando registros que no están en el JSON...');
                $this->deleteUnprocessedRecords($procesadosIds, $stats, $dryRun);
                $this->newLine();
            }

            // Mostrar resumen
            $this->showSummary($stats, $dryRun);

        } catch (\Exception $e) {
            $this->error('❌ Error durante la sincronización: ' . $e->getMessage());
            Log::error('Scraper sync failed', ['error' => $e->getMessage()]);
            return 1;
        }

        return 0;
    }

    /**
     * Encontrar archivo JSON en múltiples ubicaciones
     */
    private function findJsonFile($filename)
    {
        $paths = [
            base_path($filename),
            storage_path($filename),
            database_path($filename),
            base_path('n8n scraper/' . $filename),
            base_path('n8n-scraper/' . $filename),
        ];

        foreach ($paths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * Parsear archivo JSON
     */
    private function parseJson($filePath)
    {
        $content = file_get_contents($filePath);
        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Error decodificando JSON: ' . json_last_error_msg());
        }

        // Si el JSON tiene una estructura con clave raíz, extraerla
        if (isset($data['data']) && is_array($data['data'])) {
            return $data['data'];
        }
        if (isset($data['tarifas']) && is_array($data['tarifas'])) {
            return $data['tarifas'];
        }
        if (isset($data['records']) && is_array($data['records'])) {
            return $data['records'];
        }
        if (isset($data['results']) && is_array($data['results'])) {
            return $data['results'];
        }
        if (isset($data['items']) && is_array($data['items'])) {
            return $data['items'];
        }

        // Si es un array directo
        if (is_array($data) && !isset($data['name']) && !isset($data['nodes'])) {
            return $data;
        }

        // Si no encontró datos válidos
        throw new \Exception('Estructura JSON no reconocida. Esperaba: array directo, o con claves: data, tarifas, records, results, items');
    }

    /**
     * Sincronizar proveedor
     */
    private function syncProveedor($record, &$stats, $dryRun = false)
    {
        // Extraer datos del proveedor
        $nombre = $record['proveedor_nombre'] ?? $record['nombre'] ?? null;
        $web = $record['proveedor_web'] ?? $record['url'] ?? $record['web'] ?? null;
        $logo = $record['logo_url'] ?? $record['logo'] ?? null;
        $tipo = $record['tipo_servicio'] ?? $record['tipo_proveedor'] ?? 'energía';

        if (!$nombre) {
            $this->warn("    ⚠️  Sin nombre de proveedor");
            return null;
        }

        if (!$dryRun) {
            $proveedor = Proveedor::updateOrCreate(
                ['nombre' => $nombre],
                [
                    'web' => $web,
                    'logo' => $logo,
                    'tipo_proveedor' => $tipo,
                ]
            );

            if ($proveedor->wasRecentlyCreated) {
                $stats['proveedores_creados']++;
                $this->info("    ✓ Proveedor creado: $nombre");
            } else {
                $stats['proveedores_actualizados']++;
                $this->info("    ✓ Proveedor actualizado: $nombre");
            }

            return $proveedor;
        }

        $this->info("    [DRY-RUN] Proveedor: $nombre (web: $web, logo: $logo)");
        return null;
    }

    /**
     * Sincronizar servicio
     */
    private function syncServicio($record, $proveedor, &$stats, $dryRun = false)
    {
        if (!$proveedor) {
            return null;
        }

        // Extraer datos del servicio
        $nombre = $record['nombre_servicio'] ?? $record['nombre'] ?? null;
        $descripcion = $record['descripcion_servicio'] ?? $record['descripcion'] ?? null;
        $tipoNombre = $record['tipo_servicio'] ?? 'Energía';

        if (!$nombre) {
            $this->warn("    ⚠️  Sin nombre de servicio");
            return null;
        }

        if (!$dryRun) {
            // Obtener o crear tipo de servicio
            $tipo = TipoServicio::firstOrCreate(
                ['nombre' => $tipoNombre],
                ['descripcion' => "Tipo: $tipoNombre"]
            );

            // Crear/actualizar servicio
            $servicio = Servicio::updateOrCreate(
                [
                    'nombre_servicio' => $nombre,
                    'id_proveedor' => $proveedor->id,
                ],
                [
                    'id_tipo_servicio' => $tipo->id,
                    'descripcion' => $descripcion,
                ]
            );

            if ($servicio->wasRecentlyCreated) {
                $stats['servicios_creados']++;
                $this->info("    ✓ Servicio creado: $nombre");
            } else {
                $stats['servicios_actualizados']++;
                $this->info("    ✓ Servicio actualizado: $nombre");
            }

            return $servicio;
        }

        $this->info("    [DRY-RUN] Servicio: $nombre (Tipo: $tipoNombre)");
        return null;
    }

    /**
     * Sincronizar tarifa
     */
    private function syncTarifa($record, $servicio, &$stats, $dryRun = false)
    {
        if (!$servicio) {
            return null;
        }

        // Extraer datos de tarifa
        $nombre = $record['nombre_tarifa'] ?? $record['tarifa'] ?? 'Tarifa Estándar';
        $precio = floatval($record['precio'] ?? 0);
        $unidad = $record['unidad_precio'] ?? $record['unidad'] ?? 'mes';
        $permanencia = $record['permanencia'] ?? 'Sin permanencia';
        $condiciones = $record['condiciones'] ?? null;
        $urlOferta = $record['url_oferta_externa'] ?? $record['url'] ?? null;

        if ($precio <= 0) {
            $this->warn("    ⚠️  Precio inválido para tarifa: $nombre");
            return null;
        }

        if (!$dryRun) {
            $tarifa = Tarifa::updateOrCreate(
                [
                    'nombre_tarifa' => $nombre,
                    'id_servicio' => $servicio->id,
                    'precio' => $precio,
                ],
                [
                    'unidad_precio' => $unidad,
                    'permanencia' => $permanencia,
                    'condiciones' => $condiciones,
                    'url_oferta_externa' => $urlOferta,
                ]
            );

            if ($tarifa->wasRecentlyCreated) {
                $stats['tarifas_creadas']++;
                $this->info("    ✓ Tarifa creada: $nombre (€$precio/$unidad)");
            } else {
                $stats['tarifas_actualizadas']++;
                $this->info("    ✓ Tarifa actualizada: $nombre");
            }

            return $tarifa;
        }

        $this->info("    [DRY-RUN] Tarifa: $nombre (€$precio/$unidad)");
        return null;
    }

    /**
     * Sincronizar disponibilidad
     */
    private function syncDisponibilidad($record, $tarifa, &$stats, $dryRun = false)
    {
        // Extraer ubicación
        $codigoPostal = $record['codigo_postal'] ?? null;
        $ciudad = $record['ciudad'] ?? null;
        $provincia = $record['provincia'] ?? null;

        if (!$codigoPostal) {
            return;
        }

        if (!$dryRun) {
            // Crear/obtener ubicación
            $ubicacion = Ubicacion::firstOrCreate(
                ['codigo_postal' => $codigoPostal],
                [
                    'ciudad' => $ciudad ?? 'No especificada',
                    'provincia' => $provincia ?? 'No especificada',
                ]
            );

            // Crear disponibilidad
            $disponibilidad = Disponibilidad::firstOrCreate(
                [
                    'id_tarifa' => $tarifa->id,
                    'id_ubicacion' => $ubicacion->id,
                ]
            );

            if ($disponibilidad->wasRecentlyCreated) {
                $stats['disponibilidades_creadas']++;
            }
        }
    }

    /**
     * Eliminar registros no procesados
     */
    private function deleteUnprocessedRecords($procesados, &$stats, $dryRun = false)
    {
        // Proveedores no procesados
        $proveedoresNoProcessados = Proveedor::whereNotIn('id', $procesados['proveedores'] ?: [0])
            ->get();

        if ($proveedoresNoProcessados->count() > 0) {
            $this->warn("Proveedores a eliminar: " . $proveedoresNoProcessados->count());
            foreach ($proveedoresNoProcessados as $p) {
                if (!$dryRun) {
                    $p->delete();
                    $stats['proveedores_eliminados']++;
                    $this->warn("  ✗ Proveedor eliminado: {$p->nombre}");
                } else {
                    $this->warn("  [DRY-RUN] Eliminaría proveedor: {$p->nombre}");
                }
            }
        }

        // Servicios no procesados
        $serviciosNoProcessados = Servicio::whereNotIn('id', $procesados['servicios'] ?: [0])
            ->get();

        if ($serviciosNoProcessados->count() > 0) {
            $this->warn("Servicios a eliminar: " . $serviciosNoProcessados->count());
            foreach ($serviciosNoProcessados as $s) {
                if (!$dryRun) {
                    $s->delete();
                    $stats['servicios_eliminados']++;
                    $this->warn("  ✗ Servicio eliminado: {$s->nombre_servicio}");
                } else {
                    $this->warn("  [DRY-RUN] Eliminaría servicio: {$s->nombre_servicio}");
                }
            }
        }

        // Tarifas no procesadas
        $tarifasNoProcessadas = Tarifa::whereNotIn('id', $procesados['tarifas'] ?: [0])
            ->get();

        if ($tarifasNoProcessadas->count() > 0) {
            $this->warn("Tarifas a eliminar: " . $tarifasNoProcessadas->count());
            foreach ($tarifasNoProcessadas as $t) {
                if (!$dryRun) {
                    $t->delete();
                    $stats['tarifas_eliminadas']++;
                    $this->warn("  ✗ Tarifa eliminada: {$t->nombre_tarifa}");
                } else {
                    $this->warn("  [DRY-RUN] Eliminaría tarifa: {$t->nombre_tarifa}");
                }
            }
        }
    }

    /**
     * Mostrar resumen
     */
    private function showSummary($stats, $dryRun = false)
    {
        $this->newLine();
        $this->info('═══════════════════════════════════════');
        $this->info('📊 RESUMEN DE SINCRONIZACIÓN');
        $this->info('═══════════════════════════════════════');

        if ($dryRun) {
            $this->warn('[DRY-RUN] No se han realizado cambios');
            $this->newLine();
        }

        $this->line('Proveedores:');
        $this->info("  ✓ Creados: {$stats['proveedores_creados']}");
        $this->info("  ✓ Actualizados: {$stats['proveedores_actualizados']}");
        if ($stats['proveedores_eliminados'] > 0) {
            $this->warn("  ✗ Eliminados: {$stats['proveedores_eliminados']}");
        }

        $this->newLine();
        $this->line('Servicios:');
        $this->info("  ✓ Creados: {$stats['servicios_creados']}");
        $this->info("  ✓ Actualizados: {$stats['servicios_actualizados']}");
        if ($stats['servicios_eliminados'] > 0) {
            $this->warn("  ✗ Eliminados: {$stats['servicios_eliminados']}");
        }

        $this->newLine();
        $this->line('Tarifas:');
        $this->info("  ✓ Creadas: {$stats['tarifas_creadas']}");
        $this->info("  ✓ Actualizadas: {$stats['tarifas_actualizadas']}");
        if ($stats['tarifas_eliminadas'] > 0) {
            $this->warn("  ✗ Eliminadas: {$stats['tarifas_eliminadas']}");
        }

        $this->newLine();
        $this->info("  ✓ Disponibilidades creadas: {$stats['disponibilidades_creadas']}");

        $this->newLine();
        $this->info('═══════════════════════════════════════');
        $this->info('✅ Sincronización completada!');
    }
}
