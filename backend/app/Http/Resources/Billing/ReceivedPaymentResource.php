<?php

namespace App\Http\Resources\Billing;

use App\Http\Resources\Common\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ReceivedPaymentResource
 *
 * @OA\Schema(
 *     description="Resource representation of a received payment.",
 *     type="object",
 *     title="ReceivedPaymentResource",
 *     required={"id", "task_id", "payment", "payment_status", "date_received"}
 * )
 *
 * @OA\Property(
 *     property="id",
 *     type="integer",
 *     description="ID of the received payment.",
 *     example=1
 * )
 * @OA\Property(
 *     property="task_id",
 *     type="integer",
 *     description="ID of the related task.",
 *     example=1
 * )
 * @OA\Property(
 *     property="payment",
 *     type="number",
 *     format="float",
 *     description="Amount of the payment.",
 *     example=150.75
 * )
 * @OA\Property(
 *     property="payment_status",
 *     type="string",
 *     description="Status of the payment.",
 *     enum={"check", "cash", "credit card", "eft", "warranty", "other"},
 *     example="cash"
 * )
 * @OA\Property(
 *     property="pay_doc",
 *     type="string",
 *     description="Document number related to the payment.",
 *     nullable=true,
 *     example="INV-12345"
 * )
 * @OA\Property(
 *     property="date_received",
 *     type="string",
 *     format="date",
 *     description="Date when the payment was received.",
 *     example="2024-07-28"
 * )
 * @OA\Property(
 *     property="user",
 *     ref="#/components/schemas/UserResourceCommon",
 *     description="User who recorded the payment.",
 *     nullable=true
 * )
 * @OA\Property(
 *     property="notes",
 *     type="string",
 *     description="Additional notes about the payment.",
 *     nullable=true,
 *     example="Paid in full."
 * )
 * @OA\Property(
 *     property="created_at",
 *     type="string",
 *     format="date-time",
 *     description="Timestamp when the record was created.",
 *     example="2024-07-28T15:30:00Z"
 * )
 * @OA\Property(
 *     property="updated_at",
 *     type="string",
 *     format="date-time",
 *     description="Timestamp when the record was last updated.",
 *     example="2024-07-29T12:00:00Z"
 * )
 */
class ReceivedPaymentResource extends JsonResource
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
            'task_id' => $this->task_id,
            'payment' => $this->payment,
            'payment_status' => $this->payment_status,
            'pay_doc' => $this->pay_doc,
            'date_received' => $this->date_received,
            'user' => new UserResource($this->whenLoaded('user')),
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
