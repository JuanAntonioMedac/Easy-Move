<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ScraperController extends Controller
{
    /**
     * Sincronizar datos del scraper JSON
     */
    public function syncJson(Request $request)
    {
        try {
            // Validar autenticación (solo admin)
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado'
                ], 403);
            }

            $dryRun = $request->boolean('dry_run', false);
            $delete = $request->boolean('delete', false);
            $file = $request->input('file', 'n8n_scraper.json');

            // Ejecutar comando artisan
            $exitCode = Artisan::call('scraper:sync-json', [
                '--file' => $file,
                '--dry-run' => $dryRun,
                '--delete' => $delete,
            ]);

            $output = Artisan::output();

            if ($exitCode === 0) {
                Log::info('Scraper JSON sync successful', [
                    'dry_run' => $dryRun,
                    'delete' => $delete,
                    'file' => $file
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Sincronización completada exitosamente',
                    'output' => $output,
                    'dry_run' => $dryRun,
                ]);
            } else {
                throw new \Exception('Error en la sincronización');
            }

        } catch (\Exception $e) {
            Log::error('Scraper sync error', [
                'error' => $e->getMessage(),
                'file' => $file ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error en la sincronización: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Validar archivo JSON del scraper
     */
    public function validateJson(Request $request)
    {
        try {
            $file = $request->file('json_file');

            if (!$file) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se proporcionó archivo'
                ], 400);
            }

            $content = file_get_contents($file->path());
            $data = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'JSON inválido: ' . json_last_error_msg()
                ], 400);
            }

            // Extraer datos si están en estructura anidada
            if (isset($data['data'])) {
                $data = $data['data'];
            } elseif (isset($data['tarifas'])) {
                $data = $data['tarifas'];
            } elseif (isset($data['records'])) {
                $data = $data['records'];
            }

            $records = is_array($data) ? $data : [];

            return response()->json([
                'success' => true,
                'message' => 'JSON válido',
                'records_count' => count($records),
                'sample' => count($records) > 0 ? $records[0] : null,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error validando JSON: ' . $e->getMessage()
            ], 500);
        }
    }
}
