<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\InsuranceRequest;
use App\Http\Resources\Common\InsuranceResource;
use App\Models\Insurance;
use App\Traits\Additional\HandlesResourceCRUD;

class InsuranceController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleIndex(Insurance::class, \App\Http\Resources\Common\InsuranceResource::class, 'Insurance');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsuranceRequest $request)
    {
        return $this->handleStore(Insurance::class, InsuranceResource::class, $request, 'Insurance');
    }

    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        return $this->handleShow(InsuranceResource::class, $insurance, 'Insurance');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceRequest $request, Insurance $insurance)
    {
        return $this->handleUpdate(InsuranceResource::class, $request, $insurance, 'Insurance');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        return $this->handleDestroy($insurance, 'Insurance');
    }
}
