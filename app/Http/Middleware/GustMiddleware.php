<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class GustMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $guard = 'api')
    {
        $authGuard = Auth::guard($guard);

        // User not authenticated
        if ($authGuard->guest()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
                'errors' => 'You do not have permission. Please login.',
                'data' => []
            ], 401);
        }
        return $next($request);
    }
}
