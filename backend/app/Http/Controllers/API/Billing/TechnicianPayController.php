<?php

namespace App\Http\Controllers\API\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\TechnicianPayRequest;
use App\Http\Requests\Dispatch\TaskTechnicianUpdateRequest;
use App\Http\Resources\Billing\TechnicianPayResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TechnicianPayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Task $task)
    {
        $technicians = $task->technicians;

        return response()->json(TechnicianPayResource::collection($technicians));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TechnicianPayRequest $request, Task $task, User $user)
    {
        try {
            if (!$task->technicians()->where('user_id', $user->id)->exists()) {
                return response()->json(['error' => 'Technician not assigned to this task.'], Response::HTTP_NOT_FOUND);
            }

            $task->technicians()->updateExistingPivot($user->id, $request->validated());

            return response()->json(['message' => 'Technician payment updated successfully.'], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update technician payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update technician payment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
