<?php
//
//namespace App\Providers;
//
//use Illuminate\Cache\RateLimiting\Limit;
//use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\RateLimiter;
//use Illuminate\Support\Facades\Route;
//
//class RouteServiceProvider extends ServiceProvider
//{
//    /**
//     * The path to your application's "home" route.
//     *
//     * Typically, users are redirected here after authentication.
//     *
//     * @var string
//     */
//    public const HOME = '/dashboard';
//
//    /**
//     * Define your route model bindings, pattern filters, and other route configuration.
//     */
//    public function boot(): void
//    {
//        RateLimiter::for('api', function (Request $request) {
//            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
//        });
//
//        $central_domains  = $this->centralDomains();
//
//        $this->routes(function () use ($central_domains) {
//            foreach ($central_domains as $domain){
//                Route::middleware('api')
//                    ->prefix('api')
//                    ->domain($domain)
//                    ->group(base_path('routes/api.php'));
//
//                Route::middleware('web')
//                    ->domain($domain)
//                    ->group(base_path('routes/web.php'));
//            }
//
//        });
//    }
//
//
//    protected function centralDomains(): array
//    {
//        return config('tenancy.central_domains');
//    }
//}


namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {

        $this->configureRateLimiting();
        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();
            $this->mapTenantRoutes();  // Añadido para las rutas de inquilinos
        });
    }

    protected function mapTenantRoutes()
    {
        Route::middleware(['web', 'tenant'])
            ->namespace($this->namespace)
            ->group(base_path('routes/tenant.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }


    protected function mapWebRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        }
    }

    protected function mapApiRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::prefix('api')
                ->domain($domain)
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
