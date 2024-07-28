<?php

namespace App\Http\Resources\Dispatch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
