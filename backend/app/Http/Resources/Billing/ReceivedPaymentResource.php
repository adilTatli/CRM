<?php

namespace App\Http\Resources\Billing;

use App\Http\Resources\Common\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
