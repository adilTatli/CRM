<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplianceListResource extends JsonResource
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
            'serial_number' => $this->serial_number,
            'model_number' => $this->model_number,
            'brand' => $this->brand,
            'dop' => $this->dop,
            'appl_note' => $this->appl_note,
            'appliance' => new ApplianceResource($this->whenLoaded('appliance')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
