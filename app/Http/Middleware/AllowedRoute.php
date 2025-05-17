<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class AllowedRoute
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $currentRouteName = Route::currentRouteName();

        if($user->canAccess($currentRouteName))
        {
            return $next($request);
        }

        if($request->isJson())
        {
            throw new HttpResponseException(response()->json([
                'message' => 'Unauthorized.'
            ], 401));
        }
        
        abort(401);
    }
}
