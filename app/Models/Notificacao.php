<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;
    protected $table = 'notificacoes';

    public function quota()
    {
        return $this->belongsTo(Quota::class, 'quota_id');
    }

    /**
     * Obtém o sócio associado a esta notificação.
     */
    public function socio()
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }
}
