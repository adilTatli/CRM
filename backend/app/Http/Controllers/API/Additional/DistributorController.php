<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\DistributorRequest;
use App\Http\Resources\Common\DistributorResource;
use App\Models\Distributor;
use App\Traits\Additional\HandlesResourceCRUD;

/**
 * @OA\Tag(
 *     name="Additional/Distributors",
 *     description="API for managing (additional) distributors"
 * )
 */
class DistributorController extends Controller
{
    use HandlesResourceCRUD;

    /**
     * @OA\Get(
     *     path="/api/additional/distributors",
     *     tags={"Additional/Distributors"},
     *     summary="Get list of distributors",
     *     description="Returns list of distributors",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Distributor")
     *         ),
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function index()
    {
        return $this->handleIndex(Distributor::class, \App\Http\Resources\Common\DistributorResource::class, 'Distributor');
    }

    /**
     * @OA\Post(
     *     path="/api/additional/distributors",
     *     tags={"Additional/Distributors"},
     *     summary="Store a new distributor",
     *     description="Store a new distributor",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DistributorRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appliance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Distributor")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=409, description="Conflict"),
     * )
     */
    public function store(DistributorRequest $request)
    {
        return $this->handleStore(Distributor::class, DistributorResource::class, $request, 'Distributor');
    }

    /**
     * @OA\Get(
     *     path="/api/additional/distributors/{distributor}",
     *     tags={"Additional/Distributors"},
     *     summary="Get a specific distributor",
     *     description="Get a specific distributor by its ID",
     *     @OA\Parameter(
     *         name="distributor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Distributor")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function show(Distributor $distributor)
    {
        return $this->handleShow(DistributorResource::class, $distributor, 'Distributor');
    }

    /**
     * @OA\Put(
     *     path="/api/additional/distributors/{distributor}",
     *     tags={"Additional/Distributors"},
     *     summary="Update an existing distributor",
     *     description="Update an existing distributor by its ID",
     *     @OA\Parameter(
     *         name="distributor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/DistributorRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Distributor updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Distributor")
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function update(DistributorRequest $request, Distributor $distributor)
    {
        return $this->handleUpdate(\App\Http\Resources\Common\DistributorResource::class, $request, $distributor, 'Distributor');
    }

    /**
     * @OA\Delete(
     *     path="/api/additional/distributors/{distributor}",
     *     tags={"Additional/Distributors"},
     *     summary="Delete an distributor",
     *     description="Delete an distributor by its ID",
     *     @OA\Parameter(
     *         name="distributor",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Distributor deleted successfully",
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=404, description="Not Found"),
     * )
     */
    public function destroy(Distributor $distributor)
    {
        return $this->handleDestroy($distributor, 'Distributor');
    }
}
