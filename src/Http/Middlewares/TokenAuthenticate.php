<?php

namespace Amirabbas8643\Todo\Http\Middlewares;

use Amirabbas8643\Todo\Http\Facades\JsonResponse;
use App\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class TokenAuthenticate extends Middleware
{
    public function handle($request, Closure $next, ...$guard)
    {
        $token = $request->bearerToken();
        $user = User::where('api_token', $token)->first();
        if ($user) {
            auth()->login($user);
            return $next($request);
        }
        return  JsonResponse::unauthorized();
    }

    /**
     * Get the path the User should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }
}
