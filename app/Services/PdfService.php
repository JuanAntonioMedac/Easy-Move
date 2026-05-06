<?php

namespace App\Services;

use App\Models\Comparacion;
use App\Models\Tarifa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\PDF as PdfInstance;
use Illuminate\Support\Facades\Log;

class PdfService
{
    public function generateComparison(Comparacion $comparacion, ?User $usuario = null): PdfInstance
    {
        $comparacion->loadMissing([
            'tarifas.servicio.proveedor',
            'ubicacion',
            'tipoServicio',
        ]);

        $tarifas = $comparacion->tarifas->sortBy('precio')->values();
        $cheapest = $tarifas->first();
        $expensive = $tarifas->last();

        return Pdf::loadView('pdf.comparacion', [
            'comparacion' => $comparacion,
            'usuario' => $usuario,
            'tarifas' => $tarifas,
            'cheapest' => $cheapest,
            'expensive' => $expensive,
        ])->setPaper('a4', 'portrait');
    }

    public function generateTariffDetail(Comparacion $comparacion, $tarifas, ?User $usuario = null): PdfInstance
    {
        $comparacion->loadMissing(['ubicacion', 'tipoServicio']);

        return Pdf::loadView('pdf.tarifa-detalle', [
            'comparacion' => $comparacion,
            'tarifas' => $tarifas,
            'usuario' => $usuario,
        ])->setPaper('a4', 'portrait');
    }

    public function comparisonFilename(Comparacion $comparacion): string
    {
        return 'comparacion-' . $comparacion->id_comparacion . '-' . now()->format('Ymd-Hi') . '.pdf';
    }

    public function tariffFilename(?Tarifa $tarifa = null): string
    {
        $id = $tarifa ? '-' . $tarifa->id_tarifa : '';
        return 'tarifa' . $id . '-' . now()->format('Ymd-Hi') . '.pdf';
    }

    /**
     * Devuelve un data-URI base64 listo para usar como src de <img> en el PDF.
     * Acepta URLs externas (http/https) y rutas locales en el disco "public".
     * Si la imagen no se puede cargar, devuelve null para que la vista pueda
     * mostrar un fallback.
     */
    public static function embedImage(?string $logo): ?string
    {
        if (!$logo) {
            return null;
        }

        try {
            if (filter_var($logo, FILTER_VALIDATE_URL)) {
                $contents = @file_get_contents($logo);
                if ($contents === false) {
                    return null;
                }
                $mime = self::guessMimeFromUrl($logo) ?? 'image/png';
                return 'data:' . $mime . ';base64,' . base64_encode($contents);
            }

            $path = public_path('storage/' . ltrim($logo, '/'));
            if (!is_file($path)) {
                $path = storage_path('app/public/' . ltrim($logo, '/'));
            }
            if (!is_file($path)) {
                return null;
            }

            $contents = @file_get_contents($path);
            if ($contents === false) {
                return null;
            }
            $mime = self::guessMimeFromPath($path) ?? 'image/png';
            return 'data:' . $mime . ';base64,' . base64_encode($contents);
        } catch (\Throwable $e) {
            Log::warning('PdfService::embedImage falló para "' . $logo . '": ' . $e->getMessage());
            return null;
        }
    }

    private static function guessMimeFromPath(string $path): ?string
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return self::mimeFromExtension($ext);
    }

    private static function guessMimeFromUrl(string $url): ?string
    {
        $ext = strtolower(pathinfo(parse_url($url, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
        return self::mimeFromExtension($ext);
    }

    private static function mimeFromExtension(string $ext): ?string
    {
        return match ($ext) {
            'png' => 'image/png',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'webp' => 'image/webp',
            default => null,
        };
    }
}
