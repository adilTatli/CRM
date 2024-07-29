<?php

namespace App\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="TechnicianPayResource",
 *     type="object",
 *     description="Technician payment details",
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the payment record"),
 *     @OA\Property(property="user_id", type="integer", description="Unique identifier of the technician"),
 *     @OA\Property(property="name", type="string", description="Name of the technician"),
 *     @OA\Property(property="date", type="string", format="date", description="Date of the payment record"),
 *     @OA\Property(property="start_time", type="string", format="time", description="Start time of the work period"),
 *     @OA\Property(property="end_time", type="string", format="time", description="End time of the work period"),
 *     @OA\Property(property="payment_amount", type="number", format="float", description="Amount paid to the technician"),
 *     @OA\Property(property="paid_at", type="string", format="date-time", description="Date and time when payment was made"),
 *     @OA\Property(property="payment_status", type="string", description="Status of the payment"),
 * )
 */
class TechnicianPayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->pivot->id,
            'user_id' => $this->id,
            'name' => $this->name,
            'date' => $this->pivot->date,
            'start_time' => $this->pivot->start_time,
            'end_time' => $this->pivot->end_time,
            'payment_amount' => $this->pivot->payment_amount,
            'paid_at' => $this->pivot->paid_at,
            'payment_status' => $this->pivot->payment_status,
        ];
    }
}
