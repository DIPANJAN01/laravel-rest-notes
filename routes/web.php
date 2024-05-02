<?php

use Illuminate\Support\Facades\Route;

Route::middleware("auth:sanctum")->group((function () {

    Route::get('/', function () {
        return view('welcome');
    });
}));
