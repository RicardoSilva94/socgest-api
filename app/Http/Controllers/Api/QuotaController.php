<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorequotaRequest;
use App\Http\Requests\UpdatequotaRequest;
use App\Models\Quota;
use App\Http\Resources\QuotaResource;
use App\Models\Socio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuotaController extends Controller
{
    public function quotasEmAtraso()
    {
        // Obtém o utilizador autenticado
        $user = Auth::user();

        // Verifica se o utilizador tem uma entidade associada
        if (!$user->entidade) {
            return response()->json(['error' => 'O utilizador não tem uma entidade associada.'], 403);
        }

        // Obtém a data atual
        $dataAtual = now();

        // Obtém as quotas em atraso associadas à entidade do user e inclui o nome do sócio
        $quotas = Quota::where('estado', 'Não Pago')
            ->where('data_pagamento', '<', $dataAtual) // Verifica se a data de pagamento é anterior à data atual
            ->whereHas('socio', function ($query) use ($user) {
                $query->where('entidade_id', $user->entidade->id);
            })
            ->with('socio')  // Inclui os dados do sócio
            ->get();

        // Verifica se há quotas em atraso
        if ($quotas->isEmpty()) {
            return response()->json(['message' => 'Não há quotas em atraso.'], 200);
        }

        return response()->json([
            'quotas' => $quotas
        ], 200);
    }

    public function emitirQuotas(Request $request)
    {
        $user = Auth::user();

        // Verifica se o user tem uma entidade associada
        if (!$user->entidade) {
            return response()->json(['error' => 'O utilizador não tem uma entidade associada.'], 403);
        }

        // Validação dos dados
        $request->validate([
            'tipo' => 'required|in:Anual,Mensal',
            'periodo' => 'nullable|string|max:255',
            'descricao' => 'nullable|string|max:5000',
            'valor' => 'required|numeric|min:0',
            'data_pagamento' => 'required|date|after_or_equal:today', // Verifica se a data é igual ou posterior à data de hoje
        ]);

        $sociosAtivos = Socio::where('entidade_id', $user->entidade->id)
            ->where('estado', 'Activo')
            ->get();

        // Emitir quotas para cada sócio ativo
        foreach ($sociosAtivos as $socio) {
            Quota::create([
                'socio_id' => $socio->id,
                'tipo' => $request->input('tipo'), // Anual ou Mensal
                'periodo' => $request->input('periodo'),
                'descricao' => $request->input('descricao'),
                'valor' => $request->input('valor'),
                'estado' => 'Não Pago',
                'data_emissao' => now()->toDateString(), // Define a data de emissão como a data de hoje
                'data_pagamento' => $request->input('data_pagamento'),
            ]);
        }

        return response()->json(['message' => 'Quotas emitidas com sucesso para todos os sócios ativos!'], 201);
    }

    public function marcarComoPaga($id)
    {
        // Verifica se a quota existe
        $quota = Quota::find($id);

        if (!$quota) {
            return response()->json([
                'error' => 'Quota não encontrada.'
            ], 404);
        }

        // Tenta atualizar o estado da quota para "Pago"
        $success = $quota->update(['estado' => 'Pago']);

        if ($success) {
            return response()->json([
                'message' => 'Quota marcada como paga com sucesso!',
                'quota' => $quota
            ], 200);
        } else {
            return response()->json([
                'error' => 'Erro ao marcar a quota como paga.',
            ], 500);
        }
    }



    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtém o utilizador autenticado
        $user = auth()->user();

        // Verifica se o utilizador tem uma entidade associada
        if (!$user->entidade) {
            return response()->json([
                'error' => 'Entidade não encontrada para o utilizador.'
            ], 404);
        }

        // Obtém as quotas associadas à entidade do user e inclui o nome do sócio
        $quotas = Quota::whereHas('socio', function ($query) use ($user) {
            $query->where('entidade_id', $user->entidade->id);
        })
            ->with('socio')  // Inclui os dados do sócio
            ->get();

        return response()->json([
            'quotas' => $quotas
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
    public function store(StorequotaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $quota = Quota::with('socio')->findOrFail($id);
        return new QuotaResource($quota);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(quota $quota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatequotaRequest $request, quota $quota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Obtém o utilizador autenticado
        $user = auth()->user();

        // Verifica se a quota existe
        $quota = Quota::find($id);

        if (!$quota) {
            return response()->json([
                'error' => 'Quota não encontrada.'
            ], 404);
        }

        // Verifica se a quota pertence a um sócio da entidade do user
        $socio = $quota->socio; // Obtém o sócio associado à quota

        if (!$socio || $socio->entidade_id !== $user->entidade->id) {
            return response()->json([
                'error' => 'Você não tem permissão para eliminar esta quota.'
            ], 403);
        }

        // Deleta a quota
        $quota->delete();

        return response()->json([
            'message' => 'Quota eliminada com sucesso!'
        ], 200);
    }



}
