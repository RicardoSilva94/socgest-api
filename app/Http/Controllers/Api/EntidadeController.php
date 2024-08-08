<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreentidadeRequest;
use App\Http\Requests\UpdateentidadeRequest;
use App\Http\Resources\EntidadeResource;
use App\Models\Entidade;

class EntidadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return EntidadeResource::collection(entidade::all());
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(entidade $entidade)
    {
        return new EntidadeResource(entidade::where('id', $entidade)->first());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(entidade $entidade)
    {
        //
    }
}
