<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated
        if (!auth('sanctum')->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get authenticated user
        $user = auth('sanctum')->user();

        // Ensure $user is not null before checking the role
        if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }

        if ($user->role === 'student') {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden - Student access required'], 403);
    }
}