<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'periodo',
        'descricao',
        'valor',
        'data_emissao',
        'data_pagamento',
        'estado',
        'socio_id',
    ];

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'quota_id');
    }
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }

}
