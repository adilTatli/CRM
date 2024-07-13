<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\ApplianceRequest;
use App\Http\Resources\Additional\ApplianceResource;
use App\Models\Appliance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApplianceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $appliances = Appliance::all();

            return response()->json([
                'appliances' => ApplianceResource::collection($appliances),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch appliances: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch appliances. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplianceRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $appliance = Appliance::create($validatedData);

            return response()->json([
                'appliance' => new ApplianceResource($appliance),
                'message' => 'Appliance created successfully',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to create appliance: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create appliance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Appliance $appliance)
    {
        try {
            return response()->json([
                'appliance' => new ApplianceResource($appliance),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch appliance with ID ' . $appliance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch appliance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplianceRequest $request, Appliance $appliance)
    {
        try {
            $validatedData = $request->validated();

            $appliance->update($validatedData);

            return response()->json([
                'appliance' => new ApplianceResource($appliance),
                'message' => 'Appliance updated successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update appliance with ID ' . $appliance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update appliance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appliance $appliance)
    {
        try {
            $appliance->delete();

            return response()->json([
                'message' => 'Appliance deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete appliance with ID ' . $appliance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete appliance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
