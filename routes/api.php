<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')
    ->get('/convert/{from}/{to}', [CurrencyController::class, 'convert']);

Route::fallback(function () {
    return (new BaseController)->sendError('Route not found.');
});
