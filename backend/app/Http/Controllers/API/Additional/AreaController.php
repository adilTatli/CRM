<?php

namespace App\Http\Controllers\API\Additional;

use App\Http\Controllers\Controller;
use App\Http\Requests\Additional\AreaRequest;
use App\Http\Resources\Additional\AreaResource;
use App\Models\Area;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $areas = Area::all();

            return response()->json([
                'areas' => AreaResource::collection($areas),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch areas: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch areas. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $existingArea = Area::where('title', $validatedData['title'])->first();
            if ($existingArea) {
                return response()->json([
                    'message' => 'Area with this title already exists.',
                ], Response::HTTP_CONFLICT);
            }

            $area = Area::create($validatedData);

            return response()->json([
                'area' => new AreaResource($area),
                'message' => 'Area created successfully',
            ], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            Log::error('Database error while creating area: ' . $e->getMessage());
            return response()->json(['message' => 'Database error.'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error('Failed to create area: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to create area. Please try again later.'],
                Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Area $area)
    {
        try {
            return response()->json([
                'area' => new AreaResource($area),
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to fetch area with ID ' . $area->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to fetch area. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area)
    {
        try {
            $validatedData = $request->validated();

            $area->update($validatedData);

            return response()->json([
                'area' => new AreaResource($area),
                'message' => 'Area updated successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update area with ID ' . $area->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to update area. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Area $area)
    {
        try {
            $area->delete();

            return response()->json([
                'message' => 'Area deleted successfully',
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete area with ID ' . $area->id . ': ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to delete area. Please try again later.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
