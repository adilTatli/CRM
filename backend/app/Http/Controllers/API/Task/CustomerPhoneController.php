<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CustomerPhoneRequest;
use App\Http\Resources\Common\CustomerPhoneResource;
use App\Models\CustomerPhone;
use App\Models\Task;
use App\Traits\Task\HandlesResourceTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Task/CustomerPhone",
 *     description="Operations related to customer phone numbers"
 * )
 */
class CustomerPhoneController extends Controller
{
    use HandlesResourceTrait;

    /**
     * @OA\Post(
     *     path="/api/task/tasks/{task}/customer_phones",
     *     summary="Create a new customer phone record",
     *     tags={"Task/CustomerPhone"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone_number", type="string", example="123-456-7890"),
     *             @OA\Property(property="note", type="string", example="Customer's main contact number")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Customer phone created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerPhoneResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function store(CustomerPhoneRequest $request, Task $task): JsonResponse
    {
        return $this->handleStore($request, CustomerPhone::class,
            CustomerPhoneResource::class, 'Customer phone', [
            'task_id' => $task->id,
            'phone_number' => $request->input('phone_number'),
            'note' => $request->input('note'),
        ]);
    }

    /**
     * @OA\Put(
     *     path="/api/task/tasks/{task}/customer_phones/{customerPhone}",
     *     summary="Update an existing customer phone record",
     *     tags={"Task/CustomerPhone"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="customerPhone",
     *         in="path",
     *         required=true,
     *         description="ID of the customer phone",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="phone_number", type="string", example="123-456-7890"),
     *             @OA\Property(property="note", type="string", example="Updated note")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer phone updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/CustomerPhoneResource")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad Request"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function update(CustomerPhoneRequest $request, Task $task, CustomerPhone $customerPhone): JsonResponse
    {
        return $this->handleUpdate($request, CustomerPhoneResource::class,
            'Customer phone', $customerPhone, $task);
    }

    /**
     * @OA\Delete(
     *     path="/api/task/tasks/{task}/customer_phones/{customerPhone}",
     *     summary="Delete a customer phone record",
     *     tags={"Task/CustomerPhone"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         description="ID of the task",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="customerPhone",
     *         in="path",
     *         required=true,
     *         description="ID of the customer phone",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer phone deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden if customer phone does not belong to the task"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function destroy(Task $task, CustomerPhone $customerPhone): JsonResponse
    {
        return $this->handleDestroy('Customer phone', $customerPhone, $task);
    }
}
