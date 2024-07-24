<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\SeasonController;
use App\Http\Controllers\MatchesController;
use App\Http\Controllers\TournamentsController;

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

    //rutas temporadas
    Route::get('/seasons', [SeasonController::class, 'index']);
    Route::post('/seasons', [SeasonController::class, 'store']);
    Route::get('/seasons/{id}', [SeasonController::class, 'show']);
    Route::patch('/seasons/{id}', [SeasonController::class, 'update']);
    Route::delete('/seasons/{id}', [SeasonController::class, 'destroy']);

    //rutas partidos
    Route::get('/matches', [MatchesController::class, 'index']);
    Route::post('/matches', [MatchesController::class, 'store']);
    Route::get('/matches/{id}', [MatchesController::class, 'show']);
    Route::patch('/matches/{id}', [MatchesController::class, 'update']);
    Route::delete('/matches/{id}', [MatchesController::class, 'destroy']);

    //rutas torneo
    Route::get('/tournaments', [TournamentsController::class, 'index']);
    Route::get('/tournaments-with-matches', [TournamentsController::class, 'indexWithMatches']);
    Route::get('/tournaments/{id}', [TournamentsController::class, 'show']);
    Route::post('/tournaments', [TournamentsController::class, 'store']);
    Route::patch('/tournaments/{id}', [TournamentsController::class, 'update']);
    Route::delete('/tournaments/{id}', [TournamentsController::class, 'destroy']);
});

Route::post('/signup', [AuthController::class, 'sign_up']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
