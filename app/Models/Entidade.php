<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'logotipo',
        'nif',
        'email',
        'telefone',
        'morada',
        'tipo_quota',
        'valor_quota',
        'user_id',
    ];
    private mixed $nome;


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socios(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Socio::class, 'entidade_id');
    }
}
