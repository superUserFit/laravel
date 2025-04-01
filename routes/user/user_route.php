<?php

namespace Routes\User;

use App\Domains\User\Controller\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [UserController::class, 'register'])->withoutMiddleware('auth.my_middleware');
Route::post('/login', [UserController::class, 'login'])->withoutMiddleware('auth.my_middleware');

Route::middleware('auth.my_middleware')->prefix('user')->group(function() {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show'])->where('id', '[0-9a-fA-F\-]+');
});
