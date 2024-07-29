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

/**
 * @OA\Tag(
 *     name="Task/Files",
 *     description="API Endpoints for managing task files"
 * )
 */
class FileController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/task/tasks/{task}/files",
     *     tags={"Task/Files"},
     *     summary="Upload a new file for a task",
     *     description="Upload a new file and associate it with a task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FileRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="File uploaded successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FileResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Get(
     *     path="/api/task/tasks/{task}/files/{file}",
     *     tags={"Task/Files"},
     *     summary="Get a specific file associated with a task",
     *     description="Retrieve a specific file associated with a task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="file",
     *         in="path",
     *         required=true,
     *         description="ID of the file",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FileResource")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/task/tasks/{task}/files/{file}",
     *     tags={"Task/Files"},
     *     summary="Update a file associated with a task",
     *     description="Update the details of a specific file associated with a task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="file",
     *         in="path",
     *         required=true,
     *         description="ID of the file",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/FileRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/FileResource")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/task/tasks/{task}/files/{file}",
     *     tags={"Task/Files"},
     *     summary="Delete a file associated with a task",
     *     description="Remove a specific file associated with a task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="file",
     *         in="path",
     *         required=true,
     *         description="ID of the file",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="File deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
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
