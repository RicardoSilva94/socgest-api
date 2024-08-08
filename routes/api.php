<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EntidadeController;
use App\Http\Controllers\Api\SocioController;
use App\Http\Controllers\Api\QuotaController;
use App\Http\Controllers\Api\NotificacaoController;
use App\Http\Controllers\Api\AuthController;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/entidades', [EntidadeController::class, 'index']);
Route::get('/entidades/{id}', [EntidadeController::class, 'show']);
Route::get('/socios', [SocioController::class, 'index']);
Route::get('/socios/{id}', [SocioController::class, 'show']);
Route::post('/socios', [SocioController::class, 'store']);
Route::get('/quotas', [QuotaController::class, 'index']);
Route::get('/quotas/{id}', [QuotaController::class, 'show']);
Route::get('/notificacoes', [NotificacaoController::class, 'index']);
Route::get('/notificacoes/{id}', [NotificacaoController::class, 'show']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

