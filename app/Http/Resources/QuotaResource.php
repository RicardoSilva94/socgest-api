<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuotaResource extends JsonResource
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
            'data_emissao' => $this->data_emissao,
            'data_pagamento' => $this->data_pagamento,
            'valor' => $this->valor,
            'descricao' => $this->descricao,
            'estado' => $this->estado,
            'socio' => new SocioResource($this->whenLoaded('socio')), // Inclui o sócio associado
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
