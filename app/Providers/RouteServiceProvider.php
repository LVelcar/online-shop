<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Namespace para tus controladores.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Ruta a la "home" de tu aplicación.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Boot del provider.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        parent::boot(); // importante para bindings y middleware alias
    }

    /**
     * Mapear rutas de la aplicación.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapPanelRoutes(); // ahora seguro con el Kernel
    }

    /**
     * Rutas web.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Rutas API.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Rutas del panel administrativo.
     */
    protected function mapPanelRoutes(): void
    {
        // Usamos el alias 'is.admin' que ya está registrado en Kernel
        Route::prefix('panel')
            ->middleware(['web', 'auth', 'is.admin'])
            ->namespace("{$this->namespace}\Panel") // o "{$this->namespace}\Panel" si quieres separar controladores
            ->group(base_path('routes/panel.php'));
    }

    /**
     * Limites de rate para API.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
