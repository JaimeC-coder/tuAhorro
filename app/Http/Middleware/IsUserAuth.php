<?php

namespace App\Http\Middleware;

use App\Http\Response\JsonResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        if (auth('api')->user()) {
            return $next($request);
        }else{
          return JsonResponse::error(null,'No tienes permisos para acceder a este recurso',false,0,403);
        }
    }
}
