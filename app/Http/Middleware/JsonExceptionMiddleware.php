<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class JsonExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            return $next($request);
        }catch(Exception $error) {
            $status = method_exists($error, 'getCode') ? $error->getCode() : 500;

            return response()->json([
                'message' => $error->getMessage(),
                'status' => false,
                'code' => $status,
                'trace' => config('app.debug') ? $error->getTrace() : null,
            ], $status);
        }
    }
}
