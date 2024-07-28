<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Billing\ReceivedPaymentResource;
use App\Http\Resources\Common\ApplianceListResource;
use App\Http\Resources\Common\CustomerPhoneResource;
use App\Http\Resources\Common\FileResource;
use App\Http\Resources\Common\InsuranceResource;
use App\Http\Resources\Common\NoteResource;
use App\Http\Resources\Common\TaskStatusResource;
use App\Http\Resources\Dispatch\TechnicianResource;
use App\Http\Resources\Part\PartResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'insurance' => new InsuranceResource($this->whenLoaded('insurance')),
            'status' => new TaskStatusResource($this->whenLoaded('status')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'notes' => NoteResource::collection($this->whenLoaded('notes')),
            'phones' => CustomerPhoneResource::collection($this->whenLoaded('phones')),
            'files' => FileResource::collection($this->whenLoaded('files')),
            'appliance_lists' => ApplianceListResource::collection($this->whenLoaded('applianceLists')),
            'received_payments' => ReceivedPaymentResource::collection($this->whenLoaded('receivedPayments')),
            'technicians' => TechnicianResource::collection($this->whenLoaded('technicians')),
            'parts' => PartResource::collection($this->whenLoaded('parts')),
        ];
    }
}
