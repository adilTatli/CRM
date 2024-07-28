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

class TaskController extends Controller
{
    use TracksStatusChangesTrait;

    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $statuses = $request->query('status');

            $query = Task::query();

            if ($statuses) {
                $statusesArray = explode(',', $statuses);
                $query->whereIn('status_id', $statusesArray);
            }

            $tasks = $query->get();

            return response()->json($tasks, 200);
        } catch (Exception $e) {
            Log::error("Failed to fetch tasks: " . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch tasks.'], 500);
        }
    }


    /**
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
