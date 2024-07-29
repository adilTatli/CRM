<?php

namespace App\Http\Controllers\API\Dispatch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dispatch\TaskTechnicianStoreRequest;
use App\Http\Requests\Dispatch\TaskTechnicianUpdateRequest;
use App\Http\Resources\Dispatch\TechnicianResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task-Technicians",
 *     description="Operations about technicians"
 * )
 */
class TaskTechnicianController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dispatch/technicians",
     *     summary="Get list of technicians",
     *     description="Fetches a list of technicians.",
     *     tags={"Task-Technicians"},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TechnicianResourceDispatch"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Failed to fetch technicians.")
     *         )
     *     )
     * )
     */
    public function index()
    {
        try {
            $technicians = User::technicians()->get();

            return response()->json(TechnicianResource::collection($technicians));
        } catch (Exception $e) {
            Log::error('Failed to fetch technicians: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch technicians.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/dispatch/task-technicians",
     *     summary="Assign task to technician",
     *     description="Assign a task to a technician.",
     *     tags={"Task-Technicians"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskTechnicianStoreRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Task assigned to technician successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Failed to assign task to technician.")
     *         )
     *     )
     * )
     */
    public function store(TaskTechnicianStoreRequest $request)
    {
        try {
            $validated = $request->validated();

            $task = Task::findOrFail($validated['task_id']);
            $user = User::findOrFail($validated['user_id']);

            $task->technicians()->attach($user->id, [
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'payment_amount' => $validated['payment_amount'] ?? 0,
                'paid_at' => $validated['paid_at'] ?? null,
                'payment_status' => $validated['payment_status'] ?? 'not paid',
            ]);

            return response()->json(['message' => 'Task assigned to technician successfully.']);
        } catch (Exception $e) {
            Log::error('Failed to assign task to technician: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to assign task to technician.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/dispatch/task-technicians/{id}",
     *     summary="Get technician details",
     *     description="Fetches details of a specific technician.",
     *     tags={"Task-Technicians"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/TechnicianResourceDispatch")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="The specified user is not a technician.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Failed to fetch technician.")
     *         )
     *     )
     * )
     */
    public function show(User $task_technician)
    {
        try {
            if (!$task_technician->hasRole('technician')) {
                return response()->json(['error' => 'The specified user is not a technician.'], Response::HTTP_BAD_REQUEST);
            }

            $task_technician->load(['tasks' => function($query) {
                $query->withPivot('id', 'date', 'start_time', 'end_time', 'payment_amount', 'paid_at', 'payment_status');
            }, 'schedules.areas']);

            return response()->json(new TechnicianResource($task_technician));
        } catch (Exception $e) {
            Log::error('Failed to fetch technician: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch technician.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/dispatch/task-technicians/{id}",
     *     summary="Update task technician assignment",
     *     description="Updates a task technician assignment.",
     *     tags={"Task-Technicians"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TaskTechnicianUpdateRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Task technician assignment updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Task technician assignment not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Failed to update task technician assignment.")
     *         )
     *     )
     * )
     */
    public function update(TaskTechnicianUpdateRequest $request, $task_technician_id)
    {
        try {
            $taskTechnician = DB::table('task_technician')
                ->where('id', $task_technician_id)
                ->first();

            if (!$taskTechnician) {
                return response()->json(['error' => 'Task technician assignment not found.'], Response::HTTP_NOT_FOUND);
            }

            $validated = $request->validated();

            DB::table('task_technician')
                ->where('id', $task_technician_id)
                ->update([
                    'date' => $validated['date'],
                    'start_time' => $validated['start_time'],
                    'end_time' => $validated['end_time'],
                    'payment_amount' => $validated['payment_amount'] ?? 0,
                    'paid_at' => $validated['paid_at'] ?? null,
                    'payment_status' => $validated['payment_status'] ?? 'not paid',
                ]);

            return response()->json(['message' => 'Task technician assignment updated successfully.']);
        } catch (Exception $e) {
            Log::error('Failed to update task technician assignment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update task technician assignment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/dispatch/task-technicians/{id}",
     *     summary="Delete task technician assignment",
     *     description="Deletes a task technician assignment.",
     *     tags={"Task-Technicians"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="Task technician assignment deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Task technician assignment not found.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Failed to delete task technician assignment.")
     *         )
     *     )
     * )
     */
    public function destroy($task_technician_id)
    {
        try {
            $taskTechnician = DB::table('task_technician')->where('id', $task_technician_id)->first();

            if (!$taskTechnician) {
                return response()->json(['error' => 'Task technician assignment not found.'], Response::HTTP_NOT_FOUND);
            }

            DB::table('task_technician')->where('id', $task_technician_id)->delete();

            return response()->json(['message' => 'Task technician assignment deleted successfully.'], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete task technician assignment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete task technician assignment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
