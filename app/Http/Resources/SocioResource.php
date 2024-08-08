<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocioResource extends JsonResource
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
            'nif' => $this->nif,
            'email' => $this->email,
            'num_socio' => $this->num_socio,
            'telefone' => $this->telefone,
            'morada' => $this->morada,
            'estado' => $this->estado,
            'notas' => $this->notas,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'entidade' => new EntidadeResource($this->whenLoaded('entidade')),
        ];
    }
}
