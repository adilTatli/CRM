<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartResource extends JsonResource
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
            'part_number_id' => $this->part_number_id,
            'task_id' => $this->task_id,
            'appliance_id' => $this->appliance_id,
            'distributor_id' => $this->distributor_id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'qnt' => $this->qnt,
            'dealer_price' => $this->dealer_price,
            'retail_price' => $this->retail_price,
            'distributor_name' => $this->distributor_name,
            'part_description' => $this->part_description,
            'distributor_invoice' => $this->distributor_invoice,
            'eta' => $this->eta,
        ];
    }
}
