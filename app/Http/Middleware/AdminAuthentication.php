<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role != 'admin') {
            return response()->json([
                'status'=> false,
                'status_code' => 401,
                'message' => 'Kamu tidak dapat mengakses api ini!'
            ], 401);
        }

        return $next($request);
    }
}
