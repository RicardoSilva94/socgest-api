<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntidadeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'logotipo' => $this->logotipo,
            'nif' => $this->nif,
            'email' => $this->email,
            'telefone' => $this->telefone,
            'morada' => $this->morada,
            'tipo_quota' => $this->tipo_quota,
            'valor_quota' => $this->valor_quota,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
