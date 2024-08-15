<?php

use App\Http\Controllers\Api\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-email-view', function () {
    $socio = [
        'nome' => 'Exemplo de Nome',
    ];

    $quota = [
        'id' => 123,
        'valor' => 50.00,
        'data_pagamento' => now(),
        'descricao' => 'Quota anual',
    ];

    return view('emails.quota_overdue', [
        'socioName' => $socio['nome'],
        'quotaId' => $quota['id'],
        'quotaValue' => $quota['valor'],
        'dueDate' => $quota['data_pagamento']->format('d/m/Y'),
        'quotaDescricao' => $quota['descricao'],
    ]);
});


Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');

