<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/profile', [UserProfileController::class, 'store']);
    Route::get('/profile/{id}', [UserProfileController::class, 'show']);
    Route::patch('/profile/{id}', [UserProfileController::class, 'update']);
});

Route::post('/signup', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login']);
