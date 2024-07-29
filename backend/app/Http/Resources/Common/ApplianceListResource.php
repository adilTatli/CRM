<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="ApplianceListResourceCommon",
 *     type="object",
 *     required={"id", "serial_number", "model_number", "brand", "created_at", "updated_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the appliance list entry",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="serial_number",
 *         type="string",
 *         description="Serial number of the appliance",
 *         example="SN123456"
 *     ),
 *     @OA\Property(
 *         property="model_number",
 *         type="string",
 *         description="Model number of the appliance",
 *         example="ModelX1000"
 *     ),
 *     @OA\Property(
 *         property="brand",
 *         type="string",
 *         description="Brand of the appliance",
 *         example="BrandName"
 *     ),
 *     @OA\Property(
 *         property="dop",
 *         type="string",
 *         format="date",
 *         description="Date of purchase or other relevant date",
 *         example="2024-07-01"
 *     ),
 *     @OA\Property(
 *         property="appl_note",
 *         type="string",
 *         description="Additional notes about the appliance",
 *         example="Recently serviced"
 *     ),
 *     @OA\Property(
 *         property="appliance",
 *         ref="#/components/schemas/ApplianceResourceCommon",
 *         description="Detailed information about the appliance",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the appliance list entry was created",
 *         example="2024-07-01T12:34:56Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the appliance list entry was last updated",
 *         example="2024-07-10T12:34:56Z"
 *     )
 * )
 */
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
