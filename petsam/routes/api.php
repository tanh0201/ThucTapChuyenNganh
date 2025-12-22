<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmailLogApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Email Log API endpoints
Route::get('/email-logs/recent', [EmailLogApiController::class, 'recent']);
Route::get('/email-logs/stats', [EmailLogApiController::class, 'stats']);
