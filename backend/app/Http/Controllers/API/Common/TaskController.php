<?php

namespace App\Http\Controllers\API\Common;

use App\Http\Controllers\Controller;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Repositories\TaskRepositoryInterface;
use App\Traits\Task\TracksStatusChangesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Common/Tasks",
 *     description="API Endpoints for managing tasks"
 * )
 */
class TaskController extends Controller
{
    use TracksStatusChangesTrait;

    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     tags={"Common/Tasks"},
     *     summary="Get a list of tasks",
     *     description="Retrieve a list of tasks, optionally filtered by status and paginated.",
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Comma-separated list of status IDs to filter tasks by",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="Number of tasks per page for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", default=20)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number for pagination",
     *         required=false,
     *         @OA\Schema(type="integer", default=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of tasks retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="current_page", type="integer"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Task")),
     *             @OA\Property(property="first_page_url", type="string"),
     *             @OA\Property(property="from", type="integer"),
     *             @OA\Property(property="last_page", type="integer"),
     *             @OA\Property(property="last_page_url", type="string"),
     *             @OA\Property(property="next_page_url", type="string"),
     *             @OA\Property(property="path", type="string"),
     *             @OA\Property(property="per_page", type="integer"),
     *             @OA\Property(property="prev_page_url", type="string"),
     *             @OA\Property(property="to", type="integer"),
     *             @OA\Property(property="total", type="integer")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function index(Request $request)
    {
        try {
            $statuses = $request->query('status');
            $perPage = $request->query('per_page', 20);

            $query = Task::query();

            if ($statuses) {
                $statusesArray = explode(',', $statuses);
                $query->whereIn('status_id', $statusesArray);
            }

            $tasks = $query->paginate($perPage);

            return response()->json($tasks, 200);
        } catch (Exception $e) {
            Log::error("Failed to fetch tasks: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch tasks.'], 500);
        }
    }


    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     tags={"Common/Tasks"},
     *     summary="Get a specific task by ID",
     *     description="Retrieve a specific task by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/TaskResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $task = $this->taskRepository->findById($id);

            if (!$task) {
                return response()->json(['message' => 'Task not found.'], Response::HTTP_NOT_FOUND);
            }

            return new TaskResource($task);
        } catch (Exception $e) {
            Log::error('Error fetching task: ' . $e->getMessage(), [
                'task_id' => $id,
                'exception' => $e,
            ]);

            return response()->json([
                'message' => 'An error occurred while fetching the task.',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{task}",
     *     tags={"Common/Tasks"},
     *     summary="Update a specific task",
     *     description="Update the status of a specific task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status_id"},
     *             @OA\Property(property="status_id", type="integer", description="ID of the new status")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Task updated successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     )
     * )
     */
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'status_id' => 'required|exists:task_statuses,id',
        ]);

        try {
            $task->update($request->all());

            $this->recordStatusChange($task->id, $request->status_id);

            return response()->json(['message' => 'Task updated successfully.'], 200);
        } catch (Exception $e) {
            Log::error("Failed to update task: " . $e->getMessage());
            return response()->json(['error' => 'Failed to update task.'], 500);
        }
    }
}
