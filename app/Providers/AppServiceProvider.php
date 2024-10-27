<?php

namespace App\Providers;

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

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
        Route::aliasMiddleware('auth.my_middleware', AuthMiddleware::class);

        Route::prefix('api')
        ->middleware(['api', 'auth.my_middleware'])
        ->group(base_path('routes/user/user_route.php'));
    }
}
