<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AgeVerificationMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Please log in to continue.'], 401);
            }
            return redirect()->route('login')->with('error', 'Please log in to continue.');
        }

        if (!$user->isVerified()) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Age verification required. You must be 18+ and verified to purchase gel blasters.'], 403);
            }
            return redirect()->route('verification.show')->with('error', 
                'Age verification required. You must be 18+ and verified to purchase gel blasters.');
        }

        return $next($request);
    }
}