<?php

namespace Routes\User;

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [UserController::class, 'register'])->withoutMiddleware('auth.my_middleware');
Route::post('/login', [UserController::class, 'login'])->withoutMiddleware('auth.my_middleware');

Route::middleware('auth.my_middleware')->prefix('user')->group(function() {
    Route::get('/', [UserController::class, 'index']);
});
