<?php

namespace App\Http\Middleware;

use App\Helpers\Helpers;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authorizationHeader = $request->headers->get('Authorization');
        if(empty($authorizationHeader)) {
            return Helpers::ErrorException('Missing Authorization header', 400);
        }

        $encodedCredentials = substr($authorizationHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials);

        list($username, $access_token) = explode(':', $decodedCredentials, 2);

        $User = User::where(['username' => $username])->first();

        if(empty($User) || $User->access_token !== $access_token) {
            return Helpers::ErrorException('Unauthorized user', 401);
        }

        Auth::login($User);

        return $next($request);
    }
}
