<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::resource('/customers', CustomerApiController::class);
