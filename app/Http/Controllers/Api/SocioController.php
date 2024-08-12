<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoresocioRequest;
use App\Http\Requests\UpdatesocioRequest;
use App\Models\Socio;
use App\Http\Resources\SocioResource;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return SocioResource::collection(Socio::with('entidade')->get());
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
            'nif' => 'required|string|max:9|unique:socios,nif',
            'telefone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:socios,email',
            'morada' => 'nullable|string|max:255',
            'estado' => 'required|string|max:255',
            'notas' => 'nullable|string',
            'entidade_id' => 'required|exists:entidades,id', // Certifique-se que a entidade existe
        ]);

        // Criação do novo sócio
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(socio $socio)
    {
        //
    }
}
