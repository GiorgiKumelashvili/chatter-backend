<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

/**
 * @author Giorgi Kumelashvili (giorgi.kumelashvili21@gmail.com)
 * @jwt https://packalyst.com/packages/package/generationtux/jwt-artisan#creating-tokens
 */

Route::post('/token/create', [TokenController::class, 'create']);
Route::post('/token/retrieve', [TokenController::class, 'retrieve']);
Route::post('/authenticate', [AuthController::class, 'authenticate']);

// Main
Route::group(['middleware' => 'jwt'], function () {
    Route::post('/messages', [\App\Http\Controllers\MessagesController::class, 'index']);
    Route::post('/messages/create', [\App\Http\Controllers\MessagesController::class, 'create']);
});
