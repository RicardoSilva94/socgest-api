<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorenotificacaoRequest;
use App\Http\Requests\UpdatenotificacaoRequest;
use App\Models\Notificacao;
use App\Http\Resources\NotificacaoResource;

class NotificacaoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return NotificacaoResource::collection(Notificacao::with(['quota', 'socio'])->get());
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
    public function store(StorenotificacaoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $notificacao = Notificacao::with(['quota', 'socio'])->findOrFail($id);
        return new NotificacaoResource($notificacao);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(notificacao $notificacao)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatenotificacaoRequest $request, notificacao $notificacao)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(notificacao $notificacao)
    {
        //
    }
}
