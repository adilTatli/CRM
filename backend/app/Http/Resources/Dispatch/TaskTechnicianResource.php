<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TaskTechnicianResourceDispatch",
 *     type="object",
 *     title="Task Technician Resource",
 *     description="Details of a task assigned to a technician",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the task"
 *     ),
 *     @OA\Property(
 *         property="work_order",
 *         type="string",
 *         description="Work order number of the task"
 *     ),
 *     @OA\Property(
 *         property="customer_name",
 *         type="string",
 *         description="Name of the customer"
 *     ),
 *     @OA\Property(
 *         property="street",
 *         type="string",
 *         description="Street address of the task"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City where the task is located"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         description="ZIP code of the task location"
 *     ),
 *     @OA\Property(
 *         property="authorization",
 *         type="string",
 *         description="Authorization details for the task"
 *     ),
 *     @OA\Property(
 *         property="insurance_id",
 *         type="integer",
 *         description="ID of the associated insurance"
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="ID of the task status"
 *     ),
 *     @OA\Property(
 *         property="task_technician_id",
 *         type="integer",
 *         description="ID of the task technician association"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date when the task is scheduled"
 *     ),
 *     @OA\Property(
 *         property="start_time",
 *         type="string",
 *         format="time",
 *         description="Start time of the task"
 *     ),
 *     @OA\Property(
 *         property="end_time",
 *         type="string",
 *         format="time",
 *         description="End time of the task"
 *     ),
 *     @OA\Property(
 *         property="payment_amount",
 *         type="number",
 *         format="float",
 *         description="Amount of payment assigned to the technician"
 *     ),
 *     @OA\Property(
 *         property="paid_at",
 *         type="string",
 *         format="date",
 *         description="Date when the payment was made"
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         description="Status of the payment",
 *         enum={"paid", "not paid"}
 *     )
 * )
 */
class TaskTechnicianResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'work_order' => $this->work_order,
            'customer_name' => $this->customer_name,
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'authorization' => $this->authorization,
            'insurance_id' => $this->insurance_id,
            'status_id' => $this->status_id,
            'task_technician_id' => $this->pivot->id,
            'date' => $this->pivot->date,
            'start_time' => $this->pivot->start_time,
            'end_time' => $this->pivot->end_time,
            'payment_amount' => $this->pivot->payment_amount,
            'paid_at' => $this->pivot->paid_at,
            'payment_status' => $this->pivot->payment_status,
        ];
    }
}
