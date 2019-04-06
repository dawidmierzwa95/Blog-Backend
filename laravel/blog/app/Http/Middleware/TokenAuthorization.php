<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthorization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if($token && $user = User::where('api_token', $token)->first())
        {
            $request->attributes->add(['user' => $user]);

            return $next($request);
        }

        return Response::HTTP_UNAUTHORIZED;
    }
}
