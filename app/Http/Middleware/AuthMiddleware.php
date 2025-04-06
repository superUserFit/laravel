<?php

namespace App\Http\Middleware;

use Closure;

use App\Domains\User\Model\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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
            throw new BadRequestHttpException('Missing Authorization header', null, 400);
        }

        $encodedCredentials = substr($authorizationHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials);

        list($username, $access_token) = explode(':', $decodedCredentials, 2);

        $User = User::where(['username' => $username])->first();

        if(empty($User) || !$User->validateAccessToken($access_token)) {
            throw new UnauthorizedException('Session expired', 401);
        }

        Auth::login($User);

        return $next($request);
    }
}
