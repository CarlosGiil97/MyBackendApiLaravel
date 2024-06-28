<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamsController;

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    //rutas usuario
    Route::get('/user/{id}/profile', [UserController::class, 'profile']);


    //rutas perfil de usuario
    Route::post('/profile', [UserProfileController::class, 'store']);
    Route::get('/profile/{id}', [UserProfileController::class, 'show']);
    Route::patch('/profile/{id}', [UserProfileController::class, 'update']);

    //rutas perfil de Equipos
    Route::post('/teams', [TeamsController::class, 'store']);
    Route::get('/teams', [TeamsController::class, 'index']);
    Route::get('/teams/{id}', [TeamsController::class, 'show']);
    Route::patch('/teams/{id}', [TeamsController::class, 'update']);
    Route::delete('/teams/{id}', [TeamsController::class, 'destroy']);
});

Route::post('/signup', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login']);
