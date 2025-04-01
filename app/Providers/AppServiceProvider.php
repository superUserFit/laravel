<?php

namespace App\Providers;

use App\Domains\User\Repository\UserRepository;
use App\Domains\User\Service\UserService;
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
        $this->app->bind(UserRepository::class, function($app) {
            return new UserRepository;
        });

        $this->app->bind(UserService::class, function($app) {
            return new UserService($app->make(UserRepository::class));
        });
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
