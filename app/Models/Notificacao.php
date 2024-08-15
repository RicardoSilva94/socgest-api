<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    use HasFactory;
    protected $fillable = ['socio_id', 'quota_id', 'mensagem', 'estado', 'data_envio'];

    protected $table = 'notificacoes';

    public function quota(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Quota::class, 'quota_id');
    }

    /**
     * Obtém o sócio associado a esta notificação.
     */
    public function socio(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Socio::class, 'socio_id');
    }
}
