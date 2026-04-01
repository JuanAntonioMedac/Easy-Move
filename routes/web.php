<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SearchController::class, 'index'])->name('home');
Route::post('/search', [SearchController::class, 'search'])->name('search');

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
    Route::get('/comparacion/{comparacion}', [SearchController::class, 'showComparison'])->name('comparacion.show');
    Route::post('/export-pdf', [SearchController::class, 'exportPdf'])->name('export-pdf');
    Route::post('/send-email', [SearchController::class, 'sendEmail'])->name('send-email');
});
