<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\ApplianceRequest;
use App\Http\Resources\Common\ApplianceResource;
use App\Models\Appliance;
use App\Traits\Additional\HandlesResourceCRUD;

/**
 * @OA\Tag(
 *     name="Additional/Appliances",
 *     description="API Endpoints for managing (additional) appliances"
 * )
 */
class ApplianceController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * @OA\Get(
     *     path="/api/additional/appliances",
     *     tags={"Additional/Appliances"},
     *     summary="Get list of appliances",
     *     description="Returns list of appliances",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Appliance")
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index()
    {
        return $this->handleIndex(Appliance::class, ApplianceResource::class, 'Appliance');
    }

    /**
     * @OA\Post(
     *     path="/api/additional/appliances",
     *     tags={"Additional/Appliances"},
     *     summary="Store a new appliance",
     *     description="Store a new appliance",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ApplianceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appliance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appliance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=409, description="Conflict"),
     * )
     */
    public function store(ApplianceRequest $request)
    {
        return $this->handleStore(Appliance::class, \App\Http\Resources\Common\ApplianceResource::class, $request, 'Appliance');
    }

    /**
     * @OA\Get(
     *     path="/api/additional/appliances/{appliance}",
     *     tags={"Additional/Appliances"},
     *     summary="Get a specific appliance",
     *     description="Get a specific appliance by its ID",
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Appliance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function show(Appliance $appliance)
    {
        return $this->handleShow(\App\Http\Resources\Common\ApplianceResource::class, $appliance, 'Appliance');
    }

    /**
     * @OA\Put(
     *     path="/api/additional/appliances/{appliance}",
     *     tags={"Additional/Appliances"},
     *     summary="Update an existing appliance",
     *     description="Update an existing appliance by its ID",
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ApplianceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appliance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function update(ApplianceRequest $request, Appliance $appliance)
    {
        return $this->handleUpdate(\App\Http\Resources\Common\ApplianceResource::class, $request, $appliance, 'Appliance');
    }

    /**
     * @OA\Delete(
     *     path="/api/additional/appliances/{appliance}",
     *     tags={"Additional/Appliances"},
     *     summary="Delete an appliance",
     *     description="Delete an appliance by its ID",
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance deleted successfully",
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function destroy(Appliance $appliance)
    {
        return $this->handleDestroy($appliance, 'Appliance');
    }
}
