<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Age verification removed - all authenticated users can now purchase
        return $next($request);
    }
}