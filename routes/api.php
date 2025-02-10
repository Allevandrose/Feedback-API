<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SubmissionController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::apiResource('questions', QuestionController::class);
        Route::apiResource('answers', AnswerController::class);
    });

    // Student-only routes
    Route::middleware('student')->group(function () {
        Route::apiResource('submissions', SubmissionController::class);
    });

    // Logout route
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    });
});