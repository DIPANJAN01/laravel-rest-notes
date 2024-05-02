<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthManager::class, 'login']);
Route::post('/register', [AuthManager::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/yo', function (Request $request) {
        return response()->json("Hello");
    });
});
