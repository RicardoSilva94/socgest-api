<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreentidadeRequest;
use App\Http\Requests\UpdateentidadeRequest;
use App\Http\Resources\EntidadeResource;
use App\Models\Entidade;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class EntidadeController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EntidadeResource::collection(Entidade::all());
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
    public function store(Request $request)
    {

        // Validar os dados manualmente
        try {
            $validatedData = $request->validate([
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
                    Rule::unique('entidades', 'user_id')
                ],
            ]);

            // Verificar se o user já tem uma entidade associada
            $usuarioAtual = Auth::user();
            if ($usuarioAtual->entidade()->exists()) {
                Log::warning('O utilizador já tem uma entidade associada.');
                return response()->json([
                    'message' => 'Você já possui uma entidade associada. Não é permitido criar mais de uma.',
                ], 403);
            }

            // Processar o logotipo, se houver
            if ($request->hasFile('logotipo')) {
                $logotipoPath = $request->file('logotipo')->store('logotipos', 'public');
                $validatedData['logotipo'] = $logotipoPath;
            }

            // Adicionar o user_id aos dados validados
            $validatedData['user_id'] = $usuarioAtual->id;

            // Criar a nova entidade
            $entidade = Entidade::create($validatedData);

            return response()->json([
                'message' => 'Entidade criada com sucesso!',
                'entidade' => $entidade
            ], 201);

        } catch (ValidationException $e) {
            Log::error('Erro de validação: ', $e->errors());
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Erro ao criar entidade: ' . $e->getMessage());
            return response()->json(['message' => 'Erro ao criar a entidade.'], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Entidade $entidade)
    {
        return new EntidadeResource($entidade);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(entidade $entidade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateentidadeRequest $request, entidade $entidade)
    {
        try {
            // Valida os dados da requisição
            $validatedData = $request->validated();

            // Processa o upload do logotipo se houver
            if ($request->hasFile('logotipo')) {
                // Opcional: Excluir o logotipo antigo se existir
                if ($entidade->logotipo) {
                    Storage::disk('public')->delete($entidade->logotipo);
                }

                $logotipoPath = $request->file('logotipo')->store('logotipos', 'public');
                $validatedData['logotipo'] = $logotipoPath;
            }

            // Atualiza a entidade com os dados validados
            $entidade->update($validatedData);

            // Retorna a entidade atualizada
            return response()->json([
                'message' => 'Entidade atualizada com sucesso!',
                'entidade' => new EntidadeResource($entidade),
            ], 200);

        } catch (ValidationException $e) {
            Log::error('Erro de validação na atualização da entidade: ', $e->errors());

            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            Log::error('Erro ao atualizar a entidade: ' . $e->getMessage());

            return response()->json([
                'message' => 'Erro ao atualizar a entidade.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(entidade $entidade)
    {
        try {
            // Opcional: Excluir o logotipo associado se existir
            if ($entidade->logotipo) {
                Storage::disk('public')->delete($entidade->logotipo);
            }

            // Exclui a entidade
            $entidade->delete();

            return response()->json([
                'message' => 'Entidade excluída com sucesso.',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erro ao excluir a entidade: ' . $e->getMessage());

            return response()->json([
                'message' => 'Erro ao excluir a entidade.',
            ], 500);
        }
    }
}
