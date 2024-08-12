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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/change-name', [UserController::class, 'changeName']);
});

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


Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->middleware('guest')
    ->name('password.email');


Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? response()->json(['status' => __($status)], 200)
        : response()->json(['email' => [__($status)]], 400);
})->middleware('guest')->name('password.update');
