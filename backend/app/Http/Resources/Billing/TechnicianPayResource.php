<?php

namespace App\Http\Resources\Billing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
