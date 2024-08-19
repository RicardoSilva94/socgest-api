<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Entidade;
use Illuminate\Support\Facades\Log;

class StoreentidadeRequest extends FormRequest
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
        Log::info('Aplicando regras de validação');
        return [
            'nome' => 'required|string|max:255',
            'logotipo' => 'nullable|image',
            'nif' => 'required|string|max:9|unique:entidades,nif',
            'email' => 'required|email|unique:entidades,email',
            'telefone' => 'nullable|string|max:20',
            'morada' => 'nullable|string|max:255',
            'tipo_quota' => [
                'required',
                Rule::in(['Anual', 'Mensal'])
            ],
            'valor_quota' => [
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('entidades', 'user_id') // Garante que user_id seja único na tabela entidades
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'user_id.unique' => 'Este utilizador já está associado a uma entidade.',
        ];
    }
}
