<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/**
 * @author Giorgi Kumelashvili (giorgi.kumelashvili21@gmail.com)
 * @jwt https://packalyst.com/packages/package/generationtux/jwt-artisan#creating-tokens
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/token/create', [TokenController::class, 'create']);
Route::post('/token/retrieve', [TokenController::class, 'retrieve']);

Route::post('/authenticate', [AuthController::class, 'authenticate']);

Route::get('/test', fn() => 123);

