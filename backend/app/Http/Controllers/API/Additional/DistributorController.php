<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\DistributorRequest;
use App\Http\Resources\Common\DistributorResource;
use App\Models\Distributor;
use App\Traits\Additional\HandlesResourceCRUD;

class DistributorController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleIndex(Distributor::class, \App\Http\Resources\Common\DistributorResource::class, 'Distributor');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DistributorRequest $request)
    {
        return $this->handleStore(Distributor::class, DistributorResource::class, $request, 'Distributor');
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        return $this->handleShow(DistributorResource::class, $distributor, 'Distributor');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DistributorRequest $request, Distributor $distributor)
    {
        return $this->handleUpdate(\App\Http\Resources\Common\DistributorResource::class, $request, $distributor, 'Distributor');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        return $this->handleDestroy($distributor, 'Distributor');
    }
}
