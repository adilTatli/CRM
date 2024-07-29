<?php

namespace App\Http\Controllers\API\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\StatusChangeResource;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task Status History",
 *     description="API Endpoints for managing task status history"
 * )
 */
class TaskStatusHistoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/manager/tasks/{task}/status-history",
     *     summary="Get status history of a task",
     *     tags={"Task Status History"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful retrieval of status history",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/StatusChangeResourceManager"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     ),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function index(Task $task)
    {
        try {
            $statusChanges = $task->statusChanges()->with(['status', 'user'])->get();

            return response()->json(StatusChangeResource::collection($statusChanges), Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Failed to fetch status changes: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch status changes.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
