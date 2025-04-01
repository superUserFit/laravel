<?php

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            // 'error.json' => JsonExceptionMiddleware::class,
            'auth.user' => AuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(function(Request $request, Throwable $error) {
            if($request->is('api/*')) {
                return true;
            }

            return $request->expectsJson();
        })->render(function(Throwable $error, Request $request) {
            $errorCode = $error->getCode();
            $errorName = 'Internal Server Error';

            switch($errorCode) {
                case 400:
                    $errorName = 'Bad Request';
                    break;

                case 401:
                    $errorName = 'Unauthorized';
                    break;

                case 404:
                    $errorName = 'Not Found';
                    break;

                default:
                    $errorName = 'Internal Server Error';
                    break;
            }

            return response()->json([
                'error' => $errorName,
                'message' => $error->getMessage(),
                'code' => $error->getCode(),
                'file' => $error->getFile(),
                'line' => $error->getLine()
            ], $errorCode ? : 500);
        });
    })
    ->create();
