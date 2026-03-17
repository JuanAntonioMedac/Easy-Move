<?php

use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// ============================================================================
// RUTAS DE BÚSQUEDA - SPA (Sin autenticación requerida para búsqueda)
// ============================================================================

/**
 * Ruta principal / Home
 * GET /
 * 
 * Renderiza el formulario de búsqueda principal
 * Método: SearchController@index
 */
Route::get('/', [SearchController::class, 'index'])->name('home');

/**
 * Ejecutar búsqueda de tarifas
 * POST /search
 * 
 * Requiere:
 * - codigo_postal (string)
 * - id_tipo_servicio (integer)
 * 
 * Lógica:
 * - Si usuario NO autenticado: devuelve solo 2 mejores resultados
 * - Si usuario autenticado: devuelve todos
 * 
 * Responde con JSON
 * Método: SearchController@search
 */
Route::post('/search', [SearchController::class, 'search'])->name('search');

// ============================================================================
// RUTAS DE AUTENTICACIÓN SIMPLE
// ============================================================================

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    // Lógica simple de login - aquí podrías agregar lógica real de autenticación
    // Por ahora, simplemente autenticamos un usuario de prueba
    auth()->loginUsingId(1, true); // Usuario ID 1, remember me
    return redirect('/');
})->name('login.post');

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');

// ============================================================================
// RUTAS PROTEGIDAS (Requieren autenticación)
// ============================================================================

Route::middleware('auth')->group(function () {
    /**
     * Exportar resultados a PDF
     * POST /export-pdf
     * 
     * Requiere:
     * - comparacion_id (integer)
     * 
     * Descarga un archivo PDF con la comparativa
     * Método: SearchController@exportPdf
     */
    Route::post('/export-pdf', [SearchController::class, 'exportPdf'])->name('export-pdf');

    /**
     * Enviar resultados por email
     * POST /send-email
     * 
     * Requiere:
     * - comparacion_id (integer)
     * - email (email)
     * 
     * Envía un email con PDF adjunto
     * Método: SearchController@sendEmail
     */
    Route::post('/send-email', [SearchController::class, 'sendEmail'])->name('send-email');
});

// ============================================================================
// RUTAS DE AUTENTICACIÓN (Generadas con Laravel Breeze/Jetstream)
// ============================================================================

// require __DIR__.'/auth.php'; // Descomenta si instalas Laravel Breeze o Jetstream
