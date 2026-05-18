<?php

namespace App\Providers;

use App\Models\Proveedor;
use App\Models\Servicio;
use App\Models\Tarifa;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        View::composer('layouts.admin', function ($view) {
            $view->with([
                'totalUsuarios' => User::count(),
                'totalProveedores' => Proveedor::count(),
                'totalServicios' => Servicio::count(),
                'totalTarifas' => Tarifa::count(),
            ]);
        });
    }
}
