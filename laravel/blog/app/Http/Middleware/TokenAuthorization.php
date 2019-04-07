<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  $guest
     * @return mixed
     */
    public function handle($request, Closure $next, $guest = false)
    {
        $token = $request->header('Authorization');
        $passed = false;

        if($token && $user = User::where('api_token', $token)->first())
        {
            Auth::setUser($user);

            $passed = true;
        }

        if($passed || $guest)
        {
            return $next($request);
        }

        return response()->json(['Access denied'], 403);
    }
}
