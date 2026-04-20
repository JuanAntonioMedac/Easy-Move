<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void
    {
        try {
            $sql = file_get_contents(database_path('easymove.sql'));

            // Ejecutar todo el SQL pero con error handling
            DB::unprepared($sql);
        } catch (\Exception $e) {
            // Si hay error por tabla existente, intentar solo los datos
            Log::warning('Primera ejecución falló, intentando extrayendo solo INSERTs: ' . $e->getMessage());

            try {
                $sql = file_get_contents(database_path('easymove.sql'));
                $lines = explode("\n", $sql);

                foreach ($lines as $line) {
                    $line = trim($line);
                    if (!empty($line) && str_starts_with($line, 'INSERT INTO')) {
                        try {
                            DB::unprepared(substr($line, 0, -1) . ';');
                        } catch (\Exception $insertError) {
                            Log::debug('Ignorando error en INSERT: ' . $insertError->getMessage());
                        }
                    }
                }
            } catch (\Exception $fallbackError) {
                Log::error('Error en fallback de importación SQL: ' . $fallbackError->getMessage());
            }
        }
    }

    public function down(): void
    {
        // Opcional: puedes dejarlo vacío
    }
};
