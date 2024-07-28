<?php

namespace App\Http\Controllers\API\Dispatch;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dispatch\TaskTechnicianStoreRequest;
use App\Http\Requests\Dispatch\TaskTechnicianUpdateRequest;
use App\Http\Resources\Dispatch\TechnicianResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TaskTechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
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
     * Store a newly created resource in storage.
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
     * Display the specified resource.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
