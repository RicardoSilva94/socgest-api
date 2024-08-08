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
