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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

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
            'min_precio' => 'nullable|numeric|min:0',
            'max_precio' => 'nullable|numeric|min:0',
            'ordenar_por' => 'nullable|string|in:precio_asc,precio_desc,reciente,nombre_asc',
            'buscar_nombre' => 'nullable|string|max:100',
            'permanencia' => 'nullable|array',
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
                ->with('servicio.proveedor')
                ->whereHas('servicio', function ($q) use ($validated) {
                    $q->where('id_tipo_servicio', $validated['id_tipo_servicio']);
                })
                ->whereHas('disponibilidades', function ($q) use ($ubicacion) {
                    $q->where('id_ubicacion', $ubicacion->id_ubicacion);
                });

            // Aplicar filtro de rango de precio
            if (!empty($validated['min_precio'])) {
                $tarifasQuery->where('precio', '>=', $validated['min_precio']);
            }
            if (!empty($validated['max_precio'])) {
                $tarifasQuery->where('precio', '<=', $validated['max_precio']);
            }

            // Aplicar filtro de búsqueda por nombre
            if (!empty($validated['buscar_nombre'])) {
                $tarifasQuery->where('nombre_tarifa', 'like', '%' . $validated['buscar_nombre'] . '%');
            }

            // Aplicar filtro de permanencia
            if (!empty($validated['permanencia']) && is_array($validated['permanencia'])) {
                $permanencias = $validated['permanencia'];
                $tarifasQuery->where(function ($q) use ($permanencias) {
                    foreach ($permanencias as $perm) {
                        if ($perm === 'sin_permanencia') {
                            $q->orWhereNull('permanencia')
                              ->orWhere('permanencia', '=', '')
                              ->orWhere('permanencia', 'like', '%sin permanencia%');
                        } elseif ($perm === '1mes') {
                            $q->orWhere('permanencia', 'like', '%1 mes%')
                              ->orWhere('permanencia', 'like', '%1mes%');
                        } elseif ($perm === '3meses') {
                            $q->orWhere('permanencia', 'like', '%3 meses%')
                              ->orWhere('permanencia', 'like', '%3meses%');
                        } elseif ($perm === '6meses') {
                            $q->orWhere('permanencia', 'like', '%6 meses%')
                              ->orWhere('permanencia', 'like', '%6meses%');
                        } elseif ($perm === '12meses') {
                            $q->orWhere('permanencia', 'like', '%12 meses%')
                              ->orWhere('permanencia', 'like', '%12meses%');
                        }
                    }
                });
            }

            // Aplicar ordenamiento
            $ordenar_por = $validated['ordenar_por'] ?? 'precio_asc';
            switch ($ordenar_por) {
                case 'precio_desc':
                    $tarifasQuery->orderBy('precio', 'desc');
                    break;
                case 'nombre_asc':
                    $tarifasQuery->orderBy('nombre_tarifa', 'asc');
                    break;
                case 'reciente':
                    $tarifasQuery->orderBy('id_tarifa', 'desc');
                    break;
                case 'precio_asc':
                default:
                    $tarifasQuery->orderBy('precio', 'asc');
                    break;
            }

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
                        'logo' => $tarifa->servicio->proveedor->logo_url,
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
    /**
     * Devuelve detalle de una comparación para el modal de resultados
     *
     * @param int $comparacion
     * @return \Illuminate\Http\JsonResponse
     */
    public function showComparison(int|string $comparacion)
    {
        try {
            $comparacionId = (int) $comparacion;

            $comparacionModel = Comparacion::with('tarifas.servicio.proveedor')
                ->findOrFail($comparacionId);

            if ($comparacionModel->id_usuario && $comparacionModel->id_usuario !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            $tarifas = $comparacionModel->tarifas
                ->sortBy('pivot.posicion_resultado')
                ->values()
                ->map(function ($tarifa) {
                    return [
                        'id_tarifa' => $tarifa->id_tarifa,
                        'precio' => $tarifa->precio,
                        'servicio' => [
                            'id_servicio' => $tarifa->servicio?->id_servicio,
                            'nombre_servicio' => $tarifa->servicio?->nombre_servicio,
                        ],
                        'proveedor' => [
                            'id_proveedor' => $tarifa->servicio?->proveedor?->id_proveedor,
                            'nombre' => $tarifa->servicio?->proveedor?->nombre,
                        ],
                    ];
                });

            return response()->json([
                'success' => true,
                'comparacion_id' => $comparacionModel->id_comparacion,
                'tarifas' => $tarifas,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener comparacion', [
                'comparacion_id' => $comparacion,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al cargar la comparacion',
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

    /**
     * Búsqueda avanzada con filtros (Solo para usuarios autenticados)
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchAdvanced(Request $request)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar autenticado para usar filtros avanzados',
            ], 401);
        }

        $validated = $request->validate([
            'codigo_postal' => 'required|string|max:10',
            'id_tipo_servicio' => 'required|integer|exists:tipos_servicios,id_tipo_servicio',
            'proveedores' => 'nullable|array',
            'proveedores.*' => 'integer|exists:proveedores,id_proveedor',
            'min_precio' => 'nullable|numeric|min:0',
            'max_precio' => 'nullable|numeric|min:0',
            'permanencias' => 'nullable|array',
            'permanencias.*' => 'string|in:1mes,3meses,6meses,12meses,sin_permanencia',
            'buscar_nombre' => 'nullable|string|max:255',
            'ordenar_por' => 'nullable|string|in:precio_asc,precio_desc,reciente,nombre_asc,proveedor_asc',
        ]);

        try {
            // Obtener o crear ubicación
            $ubicacion = Ubicacion::firstOrCreate(
                ['codigo_postal' => $validated['codigo_postal']],
                [
                    'codigo_postal' => $validated['codigo_postal'],
                    'ciudad' => $request->input('ciudad', 'Unknown'),
                    'provincia' => $request->input('provincia', 'Unknown'),
                ]
            );

            // Query base
            $tarifasQuery = Tarifa::query()
                ->with('servicio.proveedor')
                ->whereHas('servicio', function ($q) use ($validated) {
                    $q->where('id_tipo_servicio', $validated['id_tipo_servicio']);
                })
                ->whereHas('disponibilidades', function ($q) use ($ubicacion) {
                    $q->where('id_ubicacion', $ubicacion->id_ubicacion);
                });

            // Filtrar por proveedores
            if (!empty($validated['proveedores'])) {
                $tarifasQuery->whereHas('servicio', function ($q) use ($validated) {
                    $q->whereIn('id_proveedor', $validated['proveedores']);
                });
            }

            // Filtrar por rango de precios
            if (!empty($validated['min_precio'])) {
                $tarifasQuery->where('precio', '>=', $validated['min_precio']);
            }
            if (!empty($validated['max_precio'])) {
                $tarifasQuery->where('precio', '<=', $validated['max_precio']);
            }

            // Filtrar por permanencias
            if (!empty($validated['permanencias'])) {
                $tarifasQuery->whereIn('permanencia', $validated['permanencias']);
            }

            // Búsqueda por nombre
            if (!empty($validated['buscar_nombre'])) {
                $tarifasQuery->where('nombre_tarifa', 'like', '%' . $validated['buscar_nombre'] . '%');
            }

            // Aplicar ordenamiento
            $ordenar = $validated['ordenar_por'] ?? 'precio_asc';
            switch ($ordenar) {
                case 'precio_asc':
                    $tarifasQuery->orderBy('precio', 'asc');
                    break;
                case 'precio_desc':
                    $tarifasQuery->orderBy('precio', 'desc');
                    break;
                case 'reciente':
                    $tarifasQuery->orderBy('updated_at', 'desc');
                    break;
                case 'nombre_asc':
                    $tarifasQuery->orderBy('nombre_tarifa', 'asc');
                    break;
                case 'proveedor_asc':
                    $tarifasQuery->orderByRaw('(SELECT nombre FROM proveedores WHERE id_proveedor = servicios.id_proveedor) ASC');
                    break;
                default:
                    $tarifasQuery->orderBy('precio', 'asc');
            }

            $tarifas = $tarifasQuery->get();
            $totalResultados = count($tarifas);

            // Crear registro de comparación
            $comparacion = Comparacion::create([
                'fecha' => now(),
                'id_usuario' => Auth::id(),
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

            // Enriquecer datos
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
                        'logo' => $tarifa->servicio->proveedor->logo_url,
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
                    'meta' => [
                        'total_resultados' => $totalResultados,
                        'resultados_mostrados' => count($tarifas),
                    ],
                ],
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda avanzada: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error en la búsqueda: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Guardar una comparación
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveComparison(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Debes estar autenticado',
            ], 401);
        }

        $validated = $request->validate([
            'comparacion_id' => 'required|integer|exists:comparaciones,id_comparacion',
            'nombre' => 'required|string|max:255',
        ]);

        try {
            $comparacion = Comparacion::findOrFail($validated['comparacion_id']);

            // Verificar que la comparación pertenece al usuario
            if ($comparacion->id_usuario !== Auth::id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No autorizado',
                ], 403);
            }

            // Actualizar los datos de la comparación para "guardarla"
            // En el modelo, necesitaremos agregar un campo 'nombre_guardado' o usar el campo 'titulo'
            // Por ahora, actualizamos la fecha como indicador de que fue guardada
            $updateData = [
                'fecha' => now(),
            ];

            if (Schema::hasColumn('comparaciones', 'nombre_guardado')) {
                $updateData['nombre_guardado'] = $validated['nombre'];
            } else {
                Log::warning('La columna nombre_guardado no existe en comparaciones; se guarda solo la fecha.', [
                    'comparacion_id' => $comparacion->id_comparacion,
                ]);
            }

            DB::table('comparaciones')
                ->where('id_comparacion', $comparacion->id_comparacion)
                ->update($updateData);

            $comparacion->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Comparación guardada correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Mostrar historial de comparaciones
     *
     * @return \Illuminate\View\View
     */
    public function showHistory()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $comparaciones = Comparacion::where('id_usuario', Auth::id())
            ->with('tipoServicio', 'ubicacion')
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('comparison-history', [
            'comparaciones' => $comparaciones,
            'title' => 'Historial de Comparaciones',
            'subtitle' => 'Todas tus comparaciones realizadas',
            'emptyMessage' => 'No tienes comparaciones realizadas',
        ]);
    }

    /**
     * Mostrar solo comparaciones guardadas
     *
     * @return \Illuminate\View\View
     */
    public function showSavedComparisons()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $query = Comparacion::where('id_usuario', Auth::id())
            ->with('tipoServicio', 'ubicacion')
            ->orderBy('fecha', 'desc');

        if (Schema::hasColumn('comparaciones', 'nombre_guardado')) {
            $query->whereNotNull('nombre_guardado');
        } else {
            Log::warning('Se solicitó la vista de comparaciones guardadas sin existir la columna nombre_guardado en comparaciones.');
            $query->whereRaw('1 = 0');
        }

        $comparaciones = $query->paginate(10);

        return view('comparison-history', [
            'comparaciones' => $comparaciones,
            'title' => 'Comparaciones Guardadas',
            'subtitle' => 'Solo las comparaciones que has guardado con nombre',
            'emptyMessage' => 'No tienes comparaciones guardadas',
        ]);
    }

    /**
     * Mostrar página de comparación con tabla completa
     *
     * @param int $comparacion
     * @return \Illuminate\View\View
     */
    public function showComparisonView(int|string $comparacion)
    {
        try {
            $comparacionId = (int) $comparacion;

            $comparacionModel = Comparacion::with('tarifas.servicio.proveedor', 'ubicacion', 'tipoServicio')
                ->findOrFail($comparacionId);

            // Verificar autorización para comparaciones privadas
            if ($comparacionModel->id_usuario && $comparacionModel->id_usuario !== Auth::id()) {
                abort(403, 'No autorizado');
            }

            return view('comparison', [
                'tarifas' => $comparacionModel->tarifas()->with('servicio.proveedor')->get(),
                'comparacion_id' => $comparacionModel->id_comparacion,
                'comparacion' => $comparacionModel,
            ]);
        } catch (\Exception $e) {
            Log::error('Error al mostrar comparación', [
                'comparacion_id' => $comparacionId,
                'error' => $e->getMessage(),
            ]);
            abort(404, 'Comparación no encontrada');
        }
    }

    /**
     * Exportar comparación a PDF
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportPDF(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'comparacion_id' => 'required|integer|exists:comparaciones,id_comparacion',
            'tarifa_id' => 'nullable|integer',
        ]);

        try {
            $comparacion = Comparacion::with('ubicacion', 'tipoServicio')
                ->findOrFail($validated['comparacion_id']);

            // Verificar que la comparación pertenece al usuario
            if ($comparacion->id_usuario !== Auth::id()) {
                return response()->json(['error' => 'No autorizado'], 403);
            }

            // Determinar qué vista y tarifas usar
            $tipo_descarga = 'todas';
            $vista = 'pdf.comparacion';

            if (!empty($validated['tarifa_id'])) {
                // Descargar una tarifa específica
                $tarifas = Tarifa::with('servicio.proveedor')
                    ->where('id_tarifa', $validated['tarifa_id'])
                    ->get();
                $tipo_descarga = 'individual';
                $vista = 'pdf.tarifa-detalle';
            } else {
                // Descargar todas las tarifas de la comparación
                $tarifas = Tarifa::with('servicio.proveedor')
                    ->whereIn('id_tarifa',
                        $comparacion->tarifas->pluck('id_tarifa')->toArray()
                    )
                    ->get();
            }

            // Validar que existan tarifas
            if ($tarifas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No hay tarifas para descargar',
                ], 404);
            }

            // Generar PDF
            $pdf = Pdf::loadView($vista, [
                'comparacion' => $comparacion,
                'tarifas' => $tarifas,
                'usuario' => Auth::user(),
            ]);

            $filename = $tipo_descarga === 'individual'
                ? 'tarifa-' . now()->format('Y-m-d-Hi') . '.pdf'
                : 'comparacion-' . now()->format('Y-m-d-Hi') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            \Log::error('Error en exportPDF: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al generar PDF: ' . $e->getMessage(),
            ], 500);
        }
    }
}
