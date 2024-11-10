<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;

    //Campos que podem ser preenchidos em massa
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

    //Converte este campo para uma instância de Carbon
    protected $dates = ['data_pagamento'];

    public function notificacoes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notificacao::class, 'quota_id');
    }
    public function socio(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }

}
