<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\ApplianceRequest;
use App\Http\Resources\Common\ApplianceResource;
use App\Models\Appliance;
use App\Traits\Additional\HandlesResourceCRUD;

/**
 * @OA\Info(
 *     title="My Doc API",
 *     version="1.0.0"
 * ),
 * @OA\PathItem(
 *     path="/api/"
 * ),
 */
class ApplianceController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * @OA\Get(
     *     path="/additional/appliances",
     *     summary="Get list of appliances",
     *     tags={"Appliance"},
     *     @OA\Response(
     *         response=200,
     *         description="List of appliances",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Appliance"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function index()
    {
        return $this->handleIndex(Appliance::class, ApplianceResource::class, 'Appliance');
    }

    /**
     * @OA\Post(
     *     path="/additional/appliances",
     *     summary="Create a new appliance",
     *     tags={"Appliance"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ApplianceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appliance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Appliance")
     *     ),
     *     @OA\Response(
     *         response=409,
     *         description="Appliance with this title already exists",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function store(ApplianceRequest $request)
    {
        return $this->handleStore(Appliance::class, \App\Http\Resources\Common\ApplianceResource::class, $request, 'Appliance');
    }

    /**
     * @OA\Get(
     *     path="/additional/appliances/{appliance}",
     *     summary="Get an appliance by ID",
     *     tags={"Appliance"},
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         description="Appliance ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance details",
     *         @OA\JsonContent(ref="#/components/schemas/Appliance")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function show(Appliance $appliance)
    {
        return $this->handleShow(\App\Http\Resources\Common\ApplianceResource::class, $appliance, 'Appliance');
    }

    /**
     * @OA\Put(
     *     path="/additional/appliances/{appliance}",
     *     summary="Update an existing appliance",
     *     tags={"Appliance"},
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         description="Appliance ID",
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
     *     @OA\Response(
     *         response=409,
     *         description="Appliance with this title already exists",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function update(ApplianceRequest $request, Appliance $appliance)
    {
        return $this->handleUpdate(\App\Http\Resources\Common\ApplianceResource::class, $request, $appliance, 'Appliance');
    }

    /**
     * @OA\Delete(
     *     path="/additional/appliances/{appliance}",
     *     summary="Delete an appliance",
     *     tags={"Appliance"},
     *     @OA\Parameter(
     *         name="appliance",
     *         in="path",
     *         description="Appliance ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function destroy(Appliance $appliance)
    {
        return $this->handleDestroy($appliance, 'Appliance');
    }
}
