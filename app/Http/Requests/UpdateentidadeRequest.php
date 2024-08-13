<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateentidadeRequest extends FormRequest
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
        // Obter o ID da entidade atual para exclusão nas regras de unicidade
        $entidadeId = $this->route('entidade')->id;

        return [
            'nome' => 'sometimes|required|string|max:255',
            'logotipo' => 'sometimes|nullable|image',
            'nif' => [
                'sometimes',
                'required',
                'string',
                'max:9',
                Rule::unique('entidades', 'nif')->ignore($entidadeId),
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('entidades', 'email')->ignore($entidadeId),
            ],
            'telefone' => 'sometimes|nullable|string|max:20',
            'morada' => 'sometimes|nullable|string|max:255',
            'tipo_quota' => [
                'sometimes',
                'required',
                Rule::in(['Anual', 'Mensal']),
            ],
            'valor_quota' => [
                'sometimes',
                'required',
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/',
            ],
            'user_id' => [
                'sometimes',
                'required',
                'exists:users,id',
                Rule::unique('entidades', 'user_id')->ignore($entidadeId),
            ],
        ];
    }

    /**
     * Mensagens de erro personalizadas.
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O campo nome é obrigatório.',
            'nif.required' => 'O campo NIF é obrigatório.',
            'nif.unique' => 'Este NIF já está em uso.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'Forneça um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'tipo_quota.in' => 'O tipo de quota deve ser "Anual" ou "Mensal".',
            'valor_quota.regex' => 'O valor da quota deve ser um número com até duas casas decimais.',
            'user_id.required' => 'O campo user_id é obrigatório.',
            'user_id.exists' => 'O utilizador fornecido não existe.',
            'user_id.unique' => 'Este utilizador já está associado a uma entidade.',

        ];
    }
}
