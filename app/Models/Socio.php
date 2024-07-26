<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'entidade_id');
    }

    public function notificacoes()
    {
        return $this->hasMany(Notificacao::class, 'socio_id');
    }

    public function quotas()
    {
        return $this->hasMany(Quota::class, 'socio_id');
    }
}

