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
    public function store(StoreentidadeRequest $request)
    {
        // TODO - Corrigir erros. Quando tentou criar segunda entidade para o mesmo user, não devolve erro.
        Log::info('A requisição chegou ao método store');
        try {
            // Valida os dados da solicitação com base nas regras definidas no StoreentidadeRequest
            $validatedData = $request->validated();

            // Processa o upload do logotipo se houver
            if ($request->hasFile('logotipo')) {
                $logotipoPath = $request->file('logotipo')->store('logotipos', 'public');
                $validatedData['logotipo'] = $logotipoPath;
            }

            // Cria a nova entidade
            $entidade = Entidade::create($validatedData);

            // Retorna uma resposta JSON
            return response()->json([
                'message' => 'Entidade criada com sucesso!',
                'entidade' => $entidade
            ], 201);
            Log::info('A requisição saiu da validação');
        } catch (ValidationException $e) {
            // Log dos erros de validação e retornar a resposta JSON com o código 422
            Log::error('Validation Error: ', $e->errors());
            return response()->json([
                'message' => 'Erro de validação',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Log de outros erros e retorno de uma resposta de erro genérica
            Log::error('Erro na criação de entidade: ' . $e->getMessage());
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
