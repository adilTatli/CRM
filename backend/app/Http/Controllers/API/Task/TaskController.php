<?php

namespace App\Http\Controllers\API\Task;

use App\Enums\TaskStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskStoreRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Models\TaskBilling;
use App\Models\TaskStatus;
use App\Traits\Task\TracksStatusChangesTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task/Task",
 *     description="Operations related to tasks"
 * )
 */
class TaskController extends Controller
{
    use TracksStatusChangesTrait;

    /**
     * @OA\Post(
     *     path="/api/task/tasks",
     *     summary="Create a new task",
     *     tags={"Task/Task"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Task created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request - Status not found",
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error - Failed to create task",
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function store(TaskStoreRequest $request)
    {
        try {
            $status = TaskStatus::where('title', TaskStatusEnum::NEED_TO_SCHEDULE->value)->first();

            if (!$status) {
                return response()->json(['message' => 'Status not found.'], Response::HTTP_BAD_REQUEST);
            }

            $task = Task::create(array_merge($request->validated(), [
                'status_id' => $status->id,
            ]));

            TaskBilling::create([
                'task_id' => $task->id,
                'labor_cost' => null,
                'parts_retails' => null,
                'parts_cost' => null,
                'other_cost' => null,
                'tax_rate' => null,
                'tax_amount' => null,
                'total_cost' => null,
                'unpaid_amount' => null,
                'invoice_number' => null,
                'billed_job_note' => null,
                'started_at' => null,
                'appointment_at' => null,
            ]);

            $this->recordStatusChange($task->id, $status->id);

            return response()->json([
                'message' => 'Task created successfully',
                'task' => new TaskResource($task)
            ], Response::HTTP_CREATED);

        } catch (Exception $e) {
            Log::error('Failed to create task and billing: ' . $e->getMessage());

            return response()->json([
                'message' => 'Failed to create task. Please try again later.',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/task/tasks/{task}",
     *     summary="Get a specific task",
     *     tags={"Task/Task"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error - Error fetching task",
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function show(Task $task)
    {
        try {
            $task->load('notes.user', 'phones', 'files',
                'applianceLists.appliance', 'insurance', 'status');

            return new TaskResource($task);
        } catch (Exception $e) {
            Log::error('Error fetching task: ' . $e->getMessage(), [
                'task_id' => $task->id,
                'exception' => $e,
            ]);

            return response()->json([
                'message' => 'An error occurred while receiving the task.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
