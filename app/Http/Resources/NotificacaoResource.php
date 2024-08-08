<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificacaoResource extends JsonResource
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
            'mensagem' => $this->mensagem,
            'estado' => $this->estado,
            'data_envio' => $this->data_envio,
            'quota' => new QuotaResource($this->whenLoaded('quota')), // Inclui a quota associada
            'socio' => new SocioResource($this->whenLoaded('socio')), // Inclui o sócio associado
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
