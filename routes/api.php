<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\EntidadeController;
use App\Http\Controllers\Api\SocioController;
use App\Http\Controllers\Api\QuotaController;
use App\Http\Controllers\Api\NotificacaoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Mail\QuotaOverdueNotification;
use App\Models\Socio;
use App\Models\Quota;
use Illuminate\Support\Facades\Mail;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-name', [UserController::class, 'changeName']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/users', [UserController::class, 'destroy']);
    Route::post('/entidades', [EntidadeController::class, 'store']);
    Route::put('/entidades/{entidade}', [EntidadeController::class, 'update']);
    Route::delete('/entidades/{entidade}', [EntidadeController::class, 'destroy']);
    Route::post('/socios', [SocioController::class, 'store']);
    Route::put('/socios/{socio}', [SocioController::class, 'update']);
    Route::delete('/socios/{socio}', [SocioController::class, 'destroy']);
    Route::get('/socios', [SocioController::class, 'index']);
    Route::post('/quotas/emitir', [QuotaController::class, 'emitirQuotas']);
    Route::post('/quotas/{id}', [QuotaController::class, 'marcarComoPaga']);
    Route::get('/quotas', [QuotaController::class, 'index']);
    Route::get('/quotas/{id}', [QuotaController::class, 'show']);
    Route::delete('quotas/{id}', [QuotaController::class, 'destroy']);
    Route::Post('/notificacoes/send', [NotificacaoController::class, 'sendQuotaNotifications']);
    Route::get('/entidades', [EntidadeController::class, 'index']);
    Route::get('/entidades/{userId}', [EntidadeController::class, 'show']);
    Route::get('/socios/{id}', [SocioController::class, 'show']);
    Route::get('/notificacoes', [NotificacaoController::class, 'index']);
    Route::get('/notificacoes/{id}', [NotificacaoController::class, 'show']);
    Route::get('/user', [UserController::class, 'getCurrentUser']);
});


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');


Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'validateToken'])->name('password.reset');
