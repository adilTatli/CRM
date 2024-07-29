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

/**
 * @OA\Schema(
 *     schema="TaskResource",
 *     title="Task Resource",
 *     description="Resource schema for a task",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier of the task",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="work_order",
 *         type="string",
 *         description="Work order number",
 *         example="WO123456"
 *     ),
 *     @OA\Property(
 *         property="customer_name",
 *         type="string",
 *         description="Name of the customer",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="street",
 *         type="string",
 *         description="Street address",
 *         example="123 Elm Street"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City",
 *         example="Springfield"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         description="Zip code",
 *         example="12345"
 *     ),
 *     @OA\Property(
 *         property="authorization",
 *         type="string",
 *         description="Authorization details",
 *         example="Authorization for work"
 *     ),
 *     @OA\Property(
 *         property="insurance",
 *         ref="#/components/schemas/InsuranceResourceCommon"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         ref="#/components/schemas/TaskStatusResourceCommon"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp of the task",
 *         example="2024-07-28T12:34:56Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp of the task",
 *         example="2024-07-28T12:34:56Z"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/NoteResource")
 *     ),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CustomerPhoneResource")
 *     ),
 *     @OA\Property(
 *         property="files",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/FileResource")
 *     ),
 *     @OA\Property(
 *         property="appliance_lists",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ApplianceListResourceCommon")
 *     ),
 *     @OA\Property(
 *         property="received_payments",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ReceivedPaymentResource")
 *     ),
 *     @OA\Property(
 *         property="technicians",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TechnicianResourceDispatch")
 *     ),
 *     @OA\Property(
 *         property="parts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/PartResource")
 *     )
 * )
 */
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
