<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\FileRequest;
use App\Http\Resources\Common\FileResource;
use App\Models\Task;
use App\Models\TaskFile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request, Task $task): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('file')) {
                $fileData = TaskFile::handleFileUpload($request->file('file'));
                $data = array_merge($data, $fileData);
            }

            $data['task_id'] = $task->id;

            $taskFile = TaskFile::create($data);

            return response()->json(new FileResource($taskFile), JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error("Error creating task file: " . $e->getMessage(), [
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => "An error occurred while creating the task file.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task, TaskFile $file): JsonResponse
    {
        if ($file->task_id !== $task->id) {
            return response()->json([
                'message' => 'The task file does not belong to the specified task.',
            ], JsonResponse::HTTP_FORBIDDEN);
        }

        return response()->json(new FileResource($file), JsonResponse::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FileRequest $request, Task $task, TaskFile $file): JsonResponse
    {
        try {
            if ($file->task_id !== $task->id) {
                return response()->json([
                    'message' => 'The task file does not belong to the specified task.',
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $data = $request->validated();

            if ($request->hasFile('file')) {
                $fileData = TaskFile::handleFileUpload($request->file('file'));
                $data = array_merge($data, $fileData);
            }

            $file->update($data);

            return response()->json(new FileResource($file), JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Error updating task file: " . $e->getMessage(), [
                'resource_id' => $file->id,
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => "An error occurred while updating the task file.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, TaskFile $file): JsonResponse
    {
        try {
            if ($file->task_id !== $task->id) {
                return response()->json([
                    'message' => 'The task file does not belong to the specified task.',
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            if (Storage::exists($file->file_path)) {
                Storage::delete($file->file_path);
            }

            $file->delete();

            return response()->json([
                'message' => 'Task file deleted successfully.',
            ], JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Error deleting task file: " . $e->getMessage(), [
                'resource_id' => $file->id,
            ]);

            return response()->json([
                'message' => "An error occurred while deleting the task file.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
