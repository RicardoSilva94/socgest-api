<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'nif',
        'num_socio',
        'telefone',
        'email',
        'morada',
        'estado',
        'notas',
        'entidade_id',
    ];

    public function entidade(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Entidade::class, 'entidade_id');
    }

    public function notificacoes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Notificacao::class, 'socio_id');
    }

    public function quotas(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Quota::class, 'socio_id');
    }
}

