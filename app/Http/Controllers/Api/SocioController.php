<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoresocioRequest;
use App\Http\Requests\UpdatesocioRequest;
use App\Models\Socio;
use App\Http\Resources\SocioResource;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;


class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $entidade = $user->entidade;

        if (!$entidade) {
            return response()->json(['error' => 'Você não tem uma entidade associada.'], 403);
        }

        // obtem os sócios associados à entidade do utilizador
        $socios = Socio::where('entidade_id', $entidade->id)->get();

        // Retorna a lista de sócios em formato JSON
        return response()->json([
            'socios' => $socios
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoresocioRequest $request)
    {
        // Validação dos dados recebidos
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'nif' => 'nullable|string|max:9',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'morada' => 'nullable|string|max:255',
            'estado' => 'nullable|string|max:255',
            'notas' => 'nullable|string',
            'entidade_id' => 'required|exists:entidades,id',
        ]);

        // Obtém o último num_socio para a entidade específica
        $lastSocio = Socio::where('entidade_id', $request->entidade_id)
            ->orderBy('num_socio', 'desc')
            ->first();

        // Define o novo num_socio incrementando o último encontrado, ou 1 se não houver sócios
        $newNumSocio = $lastSocio ? $lastSocio->num_socio + 1 : 1;

        // Adiciona o novo num_socio aos dados validados
        $validatedData['num_socio'] = $newNumSocio;

        // Criação do novo sócio com o num_socio incrementado
        $socio = Socio::create($validatedData);

        return response()->json([
            'message' => 'Sócio criado com sucesso!',
            'socio' => $socio
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $socio = Socio::with('entidade')->findOrFail($id);
        return new SocioResource($socio);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(socio $socio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesocioRequest $request, socio $socio)
    {
        $user = auth()->user();
        $entidade = $user->entidade;
        if (!$entidade) {
            return response()->json(['error' => 'Você não tem uma entidade associada.'], 403);
        }

        if ($socio->entidade_id !== $entidade->id) {
            return response()->json([
                'error' => 'Você não tem permissão para editar este sócio.',
                'socio_entidade_id' => $socio->entidade_id,
                'user_entidade_id' => $entidade->id
            ], 403);
        }

        // Validação dos dados de atualização
        $validatedData = $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'nullable',
                'email',
            ],
            'telefone' => 'nullable|string|max:20',
            'morada' => 'nullable|string|max:255',
            'nif' => [
                'sometimes',
                'nullable',
                'string',
                'max:9',
                Rule::unique('socios', 'nif')->ignore($socio->id),
            ],
            'num_socio' => [
                'sometimes',
                'required',
                'integer',
                Rule::unique('socios', 'num_socio')->ignore($socio->id),
            ],
            'estado' => [
                'sometimes',
                'nullable',
                Rule::in(['Activo', 'Expulso', 'Suspenso', 'Faleceu', 'Desistiu'])
            ],
            'notas' => 'nullable|string|max:5000',
        ]);

        // Atualiza os dados do sócio
        $socio->update($validatedData);

        // Retorna resposta JSON
        return response()->json([
            'message' => 'Sócio atualizado com sucesso!',
            'socio' => $socio
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(socio $socio)
    {
            // Verifica se o sócio pertence à entidade do user logado
            $user = auth()->user();
            $entidade = $user->entidade; // Obtém a entidade associada ao user

            if (!$entidade) {
                return response()->json(['error' => 'Você não tem uma entidade associada.'], 403);
            }

            if ($socio->entidade_id !== $entidade->id) {
                return response()->json([
                    'error' => 'Você não tem permissão para excluir este sócio.',
                    'socio_entidade_id' => $socio->entidade_id,
                    'user_entidade_id' => $entidade->id
                ], 403);
            }

            // Exclui o sócio
            $socio->delete();

            return response()->json([
                'message' => 'Sócio excluído com sucesso!'
            ], 200);
    }
}
