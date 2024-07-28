<?php

namespace App\Traits\Additional;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait HandlesResourceCRUD
{
    private function formatName($name, $case = 'lowercase')
    {
        return $case === 'uppercase' ? ucfirst($name) : strtolower($name);
    }

    public function handleIndex($model, $resource, $name)
    {
        try {
            $items = $model::all();
            return $resource::collection($items);
        } catch (QueryException $e) {
            Log::error("Database error while fetching {$this->formatName($name)}: " . $e->getMessage());
            return response()->json(['message' => "Failed to fetch {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error("Failed to fetch {$this->formatName($name)}: " . $e->getMessage());
            return response()->json(['message' => "Failed to fetch {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handleStore($model, $resource, $request, $name)
    {
        try {
            $validatedData = $request->validated();

            if ($model::where('title', $validatedData['title'])->exists()) {
                return response()->json(['message' => "{$this->formatName($name, 'uppercase')} with this title already exists."], Response::HTTP_CONFLICT);
            }

            $item = $model::create($validatedData);
            return response()->json(['item' => new $resource($item), 'message' => "{$this->formatName($name, 'uppercase')} created successfully"], Response::HTTP_CREATED);
        } catch (QueryException $e) {
            Log::error("Database error while creating {$this->formatName($name)}: " . $e->getMessage());
            return response()->json(['message' => "Failed to create {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error("Failed to create {$this->formatName($name)}: " . $e->getMessage());
            return response()->json(['message' => "Failed to create {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handleShow($resource, $model, $name)
    {
        try {
            return new $resource($model);
        } catch (Exception $e) {
            Log::error("Failed to fetch {$this->formatName($name)} with ID {$model->id}: " . $e->getMessage());
            return response()->json(['message' => "Failed to fetch {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handleUpdate($resource, $request, $model, $name)
    {
        try {
            $validatedData = $request->validated();

            if ($model::where('title', $validatedData['title'])->exists()) {
                return response()->json(['message' => "{$this->formatName($name, 'uppercase')} with this title already exists."], Response::HTTP_CONFLICT);
            }

            $model->update($validatedData);
            return response()->json(['item' => new $resource($model), 'message' => "{$this->formatName($name, 'uppercase')} updated successfully"], Response::HTTP_OK);
        } catch (QueryException $e) {
            Log::error("Database error while updating {$this->formatName($name)} with ID {$model->id}: " . $e->getMessage());
            return response()->json(['message' => "Failed to update {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch (Exception $e) {
            Log::error("Failed to update {$this->formatName($name)} with ID {$model->id}: " . $e->getMessage());
            return response()->json(['message' => "Failed to update {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function handleDestroy($model, $name)
    {
        try {
            $model->delete();
            return response()->json(['message' => "{$this->formatName($name, 'uppercase')} deleted successfully"], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Failed to delete {$this->formatName($name)} with ID {$model->id}: " . $e->getMessage());
            return response()->json(['message' => "Failed to delete {$this->formatName($name)}. Please try again later."], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
