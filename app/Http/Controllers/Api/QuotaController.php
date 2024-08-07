<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorequotaRequest;
use App\Http\Requests\UpdatequotaRequest;
use App\Models\quota;

class QuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(quota $quota)
    {
        //
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
    public function destroy(quota $quota)
    {
        //
    }
}
