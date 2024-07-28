<?php

namespace App\Traits\Task;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait HandlesResourceTrait
{
    private function formatName($name, $case = 'lowercase')
    {
        return $case === 'uppercase' ? ucfirst($name) : strtolower($name);
    }

    protected function handleStore($request, $modelClass, $resourceClass, $resourceName, $additionalData = [], $withRelations = []): JsonResponse
    {
        try {
            $data = array_merge($request->validated(), $additionalData);
            $resource = $modelClass::create($data);

            if (!empty($withRelations)) {
                $resource->load($withRelations);
            }

            $resourceResponse = new $resourceClass($resource);

            return response()->json([
                'message' => "{$this->formatName($resourceName, 'uppercase')} created successfully.",
                'data' => $resourceResponse,
            ], JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error("Error creating {$this->formatName($resourceName)}: " . $e->getMessage(), [
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => "An error occurred while creating the {$this->formatName($resourceName)}.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function handleUpdate($request, $resourceClass, $resourceName, $resource, $task, $withRelations = []): JsonResponse
    {
        try {
            if ($resource->task_id !== $task->id) {
                return response()->json([
                    'message' => "{$this->formatName($resourceName, 'uppercase')} does not belong to the specified task.",
                ], JsonResponse::HTTP_BAD_REQUEST);
            }

            $resource->update($request->validated());

            if (!empty($withRelations)) {
                $resource->load($withRelations);
            }

            $resourceResponse = new $resourceClass($resource);

            return response()->json([
                'message' => "{$this->formatName($resourceName, 'uppercase')} updated successfully.",
                'data' => $resourceResponse,
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Error updating {$this->formatName($resourceName)}: " . $e->getMessage(), [
                'resource_id' => $resource->id,
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => "An error occurred while updating the {$this->formatName($resourceName)}.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    protected function handleDestroy($resourceName, $resource, $task): JsonResponse
    {
        try {
            if ($resource->task_id !== $task->id) {
                return response()->json([
                    'message' => "{$this->formatName($resourceName, 'uppercase')} does not belong to the specified task.",
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $resource->delete();

            return response()->json([
                'message' => "{$this->formatName($resourceName, 'uppercase')} deleted successfully.",
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Error deleting {$this->formatName($resourceName)}: " . $e->getMessage(), [
                'resource_id' => $resource->id,
            ]);

            return response()->json([
                'message' => "An error occurred while deleting the {$this->formatName($resourceName)}.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
