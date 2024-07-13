<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\InsuranceRequest;
use App\Http\Resources\Additional\InsuranceResource;
use App\Models\Insurance;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class InsuranceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $insurances = Insurance::all();

            return response()->json([
                'insurances' => InsuranceResource::collection($insurances),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch insurances: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch insurances. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsuranceRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $insurance = Insurance::create($validatedData);

            return response()->json([
                'insurance' => new InsuranceResource($insurance),
                'message' => 'Insurance created successfully',
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to create insurance: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create insurance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        try {
            return response()->json([
                'insurance' => new InsuranceResource($insurance),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch insurance with ID ' . $insurance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch insurance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceRequest $request, Insurance $insurance)
    {
        try {
            $validatedData = $request->validated();

            $insurance->update($validatedData);

            return response()->json([
                'insurance' => new InsuranceResource($insurance),
                'message' => 'Insurance updated successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update insurance with ID ' . $insurance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update insurance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        try {
            $insurance->delete();

            return response()->json([
                'message' => 'Insurance deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete insurance with ID ' . $insurance->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete insurance. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
