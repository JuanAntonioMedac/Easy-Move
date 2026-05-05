<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ScraperController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('home');
Route::post('/search', [SearchController::class, 'search'])->name('search');
Route::post('/search/advanced', [SearchController::class, 'searchAdvanced'])->name('search.advanced');

// ============================================================================
// RUTAS DE AUTENTICACION Y REGISTRO
// ============================================================================

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (\Illuminate\Http\Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no son correctas.',
        ]);
    })->name('login.post');

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
});

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ============================================================================
// RUTAS PROTEGIDAS
// ============================================================================

Route::middleware('auth')->group(function () {
    Route::get('/comparacion/{comparacion}', [SearchController::class, 'showComparison'])
        ->whereNumber('comparacion')
        ->name('comparacion.show');
    Route::post('/export-pdf', [SearchController::class, 'exportPDF'])->name('export-pdf');
    Route::post('/send-email', [SearchController::class, 'sendEmail'])->name('send-email');
    Route::get('/comparison/{comparacion}', [SearchController::class, 'showComparisonView'])
        ->whereNumber('comparacion')
        ->name('comparison.show');
    Route::post('/comparison/save', [SearchController::class, 'saveComparison'])->name('comparison.save');
    Route::get('/comparison/history', [SearchController::class, 'showHistory'])->name('comparison.history');
    Route::get('/comparison/saved', [SearchController::class, 'showSavedComparisons'])->name('comparison.saved');
    Route::post('/comparison/export-pdf', [SearchController::class, 'exportPDF'])->name('comparison.export-pdf');
});

// ============================================================================
// RUTAS PANEL ADMINISTRADOR (Solo para admins)
// ============================================================================

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Proveedores
    Route::get('/providers', [AdminController::class, 'indexProviders'])->name('providers.index');
    Route::get('/providers/create', [AdminController::class, 'createProvider'])->name('providers.create');
    Route::post('/providers', [AdminController::class, 'storeProvider'])->name('providers.store');
    Route::get('/providers/{proveedor}/edit', [AdminController::class, 'editProvider'])->name('providers.edit');
    Route::put('/providers/{proveedor}', [AdminController::class, 'updateProvider'])->name('providers.update');
    Route::delete('/providers/{proveedor}', [AdminController::class, 'destroyProvider'])->name('providers.destroy');

    // Servicios
    Route::get('/services', [AdminController::class, 'indexServices'])->name('services.index');
    Route::get('/services/create', [AdminController::class, 'createService'])->name('services.create');
    Route::post('/services', [AdminController::class, 'storeService'])->name('services.store');
    Route::get('/services/{servicio}/edit', [AdminController::class, 'editService'])->name('services.edit');
    Route::put('/services/{servicio}', [AdminController::class, 'updateService'])->name('services.update');
    Route::delete('/services/{servicio}', [AdminController::class, 'destroyService'])->name('services.destroy');

    // Tarifas
    Route::get('/tariffs', [AdminController::class, 'indexTariffs'])->name('tariffs.index');
    Route::get('/tariffs/create', [AdminController::class, 'createTariff'])->name('tariffs.create');
    Route::post('/tariffs', [AdminController::class, 'storeTariff'])->name('tariffs.store');
    Route::get('/tariffs/{tarifa}/edit', [AdminController::class, 'editTariff'])->name('tariffs.edit');
    Route::put('/tariffs/{tarifa}', [AdminController::class, 'updateTariff'])->name('tariffs.update');
    Route::delete('/tariffs/{tarifa}', [AdminController::class, 'destroyTariff'])->name('tariffs.destroy');

    // Códigos Postales / Ubicaciones
    Route::get('/locations', [AdminController::class, 'indexLocations'])->name('locations.index');
    Route::get('/locations/create', [AdminController::class, 'createLocation'])->name('locations.create');
    Route::post('/locations', [AdminController::class, 'storeLocation'])->name('locations.store');
    Route::get('/locations/{ubicacion}/edit', [AdminController::class, 'editLocation'])->name('locations.edit');
    Route::put('/locations/{ubicacion}', [AdminController::class, 'updateLocation'])->name('locations.update');
    Route::delete('/locations/{ubicacion}', [AdminController::class, 'destroyLocation'])->name('locations.destroy');

    // Usuarios
    Route::get('/users', [AdminController::class, 'indexUsers'])->name('users.index');
    Route::put('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Scraper
    Route::post('/scraper/sync-json', [ScraperController::class, 'syncJson'])->name('scraper.sync-json');
    Route::post('/scraper/validate-json', [ScraperController::class, 'validateJson'])->name('scraper.validate-json');
});
