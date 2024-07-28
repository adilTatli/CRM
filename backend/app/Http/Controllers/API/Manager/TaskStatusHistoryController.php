<?php

namespace App\Http\Controllers\API\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\Manager\StatusChangeResource;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TaskStatusHistoryController extends Controller
{
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
