<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\AreaRequest;
use App\Http\Resources\Common\AreaResource;
use App\Models\Area;
use App\Traits\Additional\HandlesResourceCRUD;

/**
 * @OA\Tag(
 *     name="Additional/Areas",
 *     description="API Endpoints for managing (additional) areas"
 * )
 */
class AreaController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * @OA\Get(
     *     path="/api/additional/areas",
     *     operationId="getAreas",
     *     tags={"Additional/Areas"},
     *     summary="Get list of areas",
     *     description="Returns list of areas",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Area"))
     *     )
     * )
     */
    public function index()
    {
        return $this->handleIndex(Area::class, AreaResource::class, 'Area');
    }

    /**
     * @OA\Post(
     *     path="/api/additional/areas",
     *     operationId="storeArea",
     *     tags={"Additional/Areas"},
     *     summary="Store a newly created area",
     *     description="Stores a new area in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AreaRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Area created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Area")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function store(AreaRequest $request)
    {
        return $this->handleStore(Area::class, AreaResource::class, $request, 'Area');
    }

    /**
     * @OA\Get(
     *     path="/api/additional/areas/{area}",
     *     operationId="showArea",
     *     tags={"Additional/Areas"},
     *     summary="Get a specific area",
     *     description="Returns a specific area by ID",
     *     @OA\Parameter(
     *         name="area",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the area"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Area")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Area not found"
     *     )
     * )
     */
    public function show(Area $area)
    {
        return $this->handleShow(AreaResource::class, $area, 'Area');
    }

    /**
     * @OA\Put(
     *     path="/api/additional/areas/{area}",
     *     operationId="updateArea",
     *     tags={"Additional/Areas"},
     *     summary="Update an existing area",
     *     description="Updates an area in the database",
     *     @OA\Parameter(
     *         name="area",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the area"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AreaRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Area updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Area")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Area not found"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function update(AreaRequest $request, Area $area)
    {
        return $this->handleUpdate(AreaResource::class, $request, $area, 'Area');
    }

    /**
     * @OA\Delete(
     *     path="/api/additional/areas/{area}",
     *     operationId="destroyArea",
     *     tags={"Additional/Areas"},
     *     summary="Delete an area",
     *     description="Deletes an area from the database",
     *     @OA\Parameter(
     *         name="area",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the area"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Area deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Area not found"
     *     )
     * )
     */
    public function destroy(Area $area)
    {
        return $this->handleDestroy($area, 'Area');
    }
}
