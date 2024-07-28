<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\AreaRequest;
use App\Http\Resources\Common\AreaResource;
use App\Models\Area;
use App\Traits\Additional\HandlesResourceCRUD;

class AreaController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->handleIndex(Area::class, AreaResource::class, 'Area');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        return $this->handleStore(Area::class, AreaResource::class, $request, 'Area');
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        return $this->handleShow(AreaResource::class, $area, 'Area');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area)
    {
        return $this->handleUpdate(AreaResource::class, $request, $area, 'Area');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        return $this->handleDestroy($area, 'Area');
    }
}
