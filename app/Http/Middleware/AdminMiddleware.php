<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminMiddleware
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

        Log::info('User Role:', ['role' => $user->role ?? 'undefined']); // Debugging

        if ($user->role === 'admin') {
            return $next($request);
        }

        return response()->json(['error' => 'Forbidden - Admin access required'], 403);
    }
}