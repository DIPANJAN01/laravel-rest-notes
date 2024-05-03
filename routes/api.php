<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\NoteController;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/register', [AuthManager::class, 'register'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [AuthManager::class, 'profile'])->name('profile');
    Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
    Route::delete('/profile', [AuthManager::class, 'deleteAccount'])->name('deleteAccount');

    Route::get('/yo', function () {
        return response()->json("Hello " . Auth::user()->name);
    })->name('user.yo');

    Route::apiResource("notes", NoteController::class);
});
