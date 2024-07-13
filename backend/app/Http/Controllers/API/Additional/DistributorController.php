<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\DistributorRequest;
use App\Http\Resources\Additional\DistributorResource;
use App\Models\Distributor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $distributors = Distributor::all();

            return response()->json([
                'distributors' => DistributorResource::collection($distributors),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch distributors: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch distributors. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DistributorRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $distributor = Distributor::create($validatedData);

            return response()->json([
                'distributor' => new DistributorResource($distributor),
                'message' => 'Distributor created successfully',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to create distributor: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create distributor. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        try {
            return response()->json([
                'distributor' => new DistributorResource($distributor),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch distributor with ID ' . $distributor->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch distributor. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DistributorRequest $request, Distributor $distributor)
    {
        try {
            $validatedData = $request->validated();

            $distributor->update($validatedData);

            return response()->json([
                'distributor' => new DistributorResource($distributor),
                'message' => 'Distributor updated successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update distributor with ID ' . $distributor->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update distributor. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        try {
            $distributor->delete();

            return response()->json([
                'message' => 'Distributor deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete distributor with ID ' . $distributor->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete distributor. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
