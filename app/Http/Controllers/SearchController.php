<?php

namespace App\Http\Controllers;

use App\Models\Comparacion;
use App\Models\ComparacionTarifa;
use App\Models\Tarifa;
use App\Models\TipoServicio;
use App\Models\Ubicacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SearchController extends Controller
{
    /**
     * Renderiza la página de inicio (Home)
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $tiposServicios = TipoServicio::all();
        $codigosPostales = Ubicacion::distinct()->pluck('codigo_postal')->sort()->values();

        return view('search', [
            'tiposServicios' => $tiposServicios,
            'codigosPostales' => $codigosPostales,
            'user' => Auth::user(),
        ]);
    }

    /**
     * Ejecuta la búsqueda de tarifas basada en filtros
     * 
     * Lógica crítica:
     * - Si el usuario NO está autenticado (Auth::check() === false): devuelve SOLO 2 mejores resultados por precio
     * - Si el usuario está autenticado: devuelve TODOS los resultados ordenados por precio
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'codigo_postal' => 'required|string|max:10',
            'id_tipo_servicio' => 'required|integer|exists:tipos_servicios,id_tipo_servicio',
        ]);

        try {
            // Buscar o crear la ubicación basada en código postal
            $ubicacion = Ubicacion::firstOrCreate(
                ['codigo_postal' => $validated['codigo_postal']],
                [
                    'codigo_postal' => $validated['codigo_postal'],
                    'ciudad' => $request->input('ciudad', 'Unknown'),
                    'provincia' => $request->input('provincia', 'Unknown'),
                ]
            );

            // Query base: buscar tarifas disponibles para la ubicación y tipo de servicio
            $tarifasQuery = Tarifa::query()
                ->whereHas('servicio', function ($q) use ($validated) {
                    $q->where('id_tipo_servicio', $validated['id_tipo_servicio']);
                })
                ->whereHas('disponibilidades', function ($q) use ($ubicacion) {
                    $q->where('id_ubicacion', $ubicacion->id_ubicacion);
                })
                ->orderBy('precio', 'asc');

            // Lógica crítica: Limitación de resultados por autenticación
            $isAuthenticated = Auth::check();
            if (!$isAuthenticated) {
                // Usuario NO autenticado: solo 2 mejores resultados por precio
                $tarifas = $tarifasQuery->take(2)->get();
                $isLimited = true;
                $totalResultados = Tarifa::query()
                    ->whereHas('servicio', function ($q) use ($validated) {
                        $q->where('id_tipo_servicio', $validated['id_tipo_servicio']);
                    })
                    ->whereHas('disponibilidades', function ($q) use ($ubicacion) {
                        $q->where('id_ubicacion', $ubicacion->id_ubicacion);
                    })
                    ->count();
            } else {
                // Usuario autenticado: todos los resultados
                $tarifas = $tarifasQuery->get();
                $isLimited = false;
                $totalResultados = count($tarifas);
            }

            // Crear registro de comparación
            $comparacion = Comparacion::create([
                'fecha' => now(),
                'id_usuario' => $isAuthenticated ? Auth::id() : null,
                'id_ubicacion' => $ubicacion->id_ubicacion,
                'id_tipo_servicio' => $validated['id_tipo_servicio'],
            ]);

            // Asociar tarifas a la comparación
            foreach ($tarifas as $index => $tarifa) {
                ComparacionTarifa::create([
                    'id_comparacion' => $comparacion->id_comparacion,
                    'id_tarifa' => $tarifa->id_tarifa,
                    'posicion_resultado' => $index + 1,
                ]);
            }

            // Enriquecer datos de tarifas con información del servicio y proveedor
            $tarifasData = $tarifas->map(function ($tarifa) {
                return [
                    'id_tarifa' => $tarifa->id_tarifa,
                    'nombre_tarifa' => $tarifa->nombre_tarifa,
                    'precio' => $tarifa->precio,
                    'unidad_precio' => $tarifa->unidad_precio,
                    'permanencia' => $tarifa->permanencia,
                    'condiciones' => $tarifa->condiciones,
                    'url_oferta_externa' => $tarifa->url_oferta_externa,
                    'servicio' => [
                        'id_servicio' => $tarifa->servicio->id_servicio,
                        'nombre_servicio' => $tarifa->servicio->nombre_servicio,
                        'descripcion' => $tarifa->servicio->descripcion,
                    ],
                    'proveedor' => [
                        'id_proveedor' => $tarifa->servicio->proveedor->id_proveedor,
                        'nombre' => $tarifa->servicio->proveedor->nombre,
                        'web' => $tarifa->servicio->proveedor->web,
                        'logo' => $tarifa->servicio->proveedor->logo,
                    ],
                ];
            });

            return response()->json([
                'success' => true,
                'data' => [
                    'tarifas' => $tarifasData,
                    'comparacion_id' => $comparacion->id_comparacion,
                    'ubicacion' => [
                        'id_ubicacion' => $ubicacion->id_ubicacion,
                        'codigo_postal' => $ubicacion->codigo_postal,
                        'ciudad' => $ubicacion->ciudad,
                        'provincia' => $ubicacion->provincia,
                    ],
                    'tipo_servicio' => [
                        'id_tipo_servicio' => $validated['id_tipo_servicio'],
                    ],
                    'meta' => [
                        'is_limited' => $isLimited,
                        'total_resultados' => $totalResultados,
                        'resultados_mostrados' => count($tarifas),
                        'is_authenticated' => $isAuthenticated,
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Exporta los resultados de una comparación a PDF
     * 
     * Solo accesible vía middleware 'auth'
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'comparacion_id' => 'required|integer|exists:comparaciones,id_comparacion',
        ]);

        try {
            $comparacion = Comparacion::with('tarifas.servicio.proveedor', 'ubicacion', 'tipoServicio')
                ->findOrFail($request->input('comparacion_id'));

            // Verificar que la comparación pertenece al usuario autenticado o es pública
            if ($comparacion->id_usuario && $comparacion->id_usuario !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            // Pasar los datos a la vista Blade para generar el PDF
            $pdf = Pdf::loadView('pdf.comparacion', [
                'comparacion' => $comparacion,
                'usuario' => Auth::user(),
            ]);

            return $pdf->download('comparativa-tarifas-' . now()->format('Y-m-d') . '.pdf');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Envía los resultados de una comparación por email
     * 
     * Solo accesible vía middleware 'auth'
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendEmail(Request $request)
    {
        $request->validate([
            'comparacion_id' => 'required|integer|exists:comparaciones,id_comparacion',
            'email' => 'required|email',
        ]);

        try {
            $comparacion = Comparacion::with('tarifas.servicio.proveedor', 'ubicacion', 'tipoServicio')
                ->findOrFail($request->input('comparacion_id'));

            // Verificar que la comparación pertenece al usuario autenticado
            if ($comparacion->id_usuario !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $usuario = Auth::user();
            $emailDestino = $request->input('email');

            // Generar PDF en memoria
            $pdf = Pdf::loadView('pdf.comparacion', [
                'comparacion' => $comparacion,
                'usuario' => $usuario,
            ]);

            // Enviar email con PDF adjunto
            Mail::send('emails.comparacion', ['comparacion' => $comparacion, 'usuario' => $usuario], function ($message) use ($emailDestino, $pdf) {
                $message->from(config('mail.from.address'), config('mail.from.name'))
                    ->to($emailDestino)
                    ->subject('Tu Comparativa de Tarifas - EasyMove')
                    ->attachData($pdf->output(), 'comparativa-tarifas.pdf', [
                        'mime' => 'application/pdf',
                    ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Email enviado correctamente a ' . $emailDestino,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al enviar email: ' . $e->getMessage(),
            ], 500);
        }
    }
}
