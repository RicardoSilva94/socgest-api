<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorequotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'socio_id' => 'required|exists:socios,id',
            'tipo' => 'required|in:Anual,Mensal',
            'periodo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:500',
            'valor' => 'required|numeric|min:0',
            'data_pagamento' => 'required|date|after_or_equal:today',
        ];
    }
}
