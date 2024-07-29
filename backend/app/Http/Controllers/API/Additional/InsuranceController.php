<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\InsuranceRequest;
use App\Http\Resources\Common\InsuranceResource;
use App\Models\Insurance;
use App\Traits\Additional\HandlesResourceCRUD;

/**
 * @OA\Tag(
 *     name="Additional/Insurances",
 *     description="API for managing (additional) insurances"
 * )
 */
class InsuranceController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * @OA\Get(
     *     path="/api/additional/insurances",
     *     tags={"Additional/Insurances"},
     *     summary="Get list of insurances",
     *     description="Returns list of insurances",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Insurance")
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index()
    {
        return $this->handleIndex(Insurance::class, \App\Http\Resources\Common\InsuranceResource::class, 'Insurance');
    }

    /**
     * @OA\Post(
     *     path="/api/additional/insurances",
     *     tags={"Additional/Insurances"},
     *     summary="Store a new insurance",
     *     description="Store a new insurance",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InsuranceRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Insurance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Insurance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=409, description="Conflict"),
     * )
     */
    public function store(InsuranceRequest $request)
    {
        return $this->handleStore(Insurance::class, InsuranceResource::class, $request, 'Insurance');
    }

    /**
     * @OA\Get(
     *     path="/api/additional/insurances/{insurance}",
     *     tags={"Additional/Insurances"},
     *     summary="Get a specific insurance",
     *     description="Get a specific insurance by its ID",
     *     @OA\Parameter(
     *         name="insurance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Insurance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function show(Insurance $insurance)
    {
        return $this->handleShow(InsuranceResource::class, $insurance, 'Insurance');
    }

    /**
     * @OA\Put(
     *     path="/api/additional/insurances/{insurance}",
     *     tags={"Additional/Insurances"},
     *     summary="Update an existing insurance",
     *     description="Update an existing insurance by its ID",
     *     @OA\Parameter(
     *         name="insurance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/InsuranceRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insurance updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Insurance")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function update(InsuranceRequest $request, Insurance $insurance)
    {
        return $this->handleUpdate(InsuranceResource::class, $request, $insurance, 'Insurance');
    }

    /**
     * @OA\Delete(
     *     path="/api/additional/insurances/{insurance}",
     *     tags={"Additional/Insurances"},
     *     summary="Delete an insurance",
     *     description="Delete an insurance by its ID",
     *     @OA\Parameter(
     *         name="insurance",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Insurance deleted successfully",
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function destroy(Insurance $insurance)
    {
        return $this->handleDestroy($insurance, 'Insurance');
    }
}
