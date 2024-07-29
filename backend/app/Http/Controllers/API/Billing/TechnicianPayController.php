<?php

namespace App\Http\Controllers\API\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\TechnicianPayRequest;
use App\Http\Resources\Billing\TechnicianPayResource;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="TechnicianPay",
 *     description="Operations related to managing technician payments."
 * )
 */
class TechnicianPayController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/billing/tasks/{task}/technicians",
     *     operationId="getTechnicianPayments",
     *     tags={"TechnicianPay"},
     *     summary="Get payments for technicians assigned to a task",
     *     description="Retrieve a list of payments for technicians associated with a specific task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         description="ID of the task",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/TechnicianPayResource"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Task not found.")
     *         )
     *     )
     * )
     */
    public function index(Task $task)
    {
        $technicians = $task->technicians;

        return response()->json(TechnicianPayResource::collection($technicians));
    }

    /**
     * @OA\Patch(
     *     path="/api/billing/tasks/{task}/technicians/{user}",
     *     operationId="updateTechnicianPayment",
     *     tags={"TechnicianPay"},
     *     summary="Update a technician's payment information for a specific task",
     *     description="Update the payment details for a technician assigned to a task.",
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         description="ID of the task",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID of the technician (user)",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/TechnicianPayRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Technician payment updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Technician not assigned to this task",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Technician not assigned to this task.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update technician payment",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to update technician payment.")
     *         )
     *     )
     * )
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
