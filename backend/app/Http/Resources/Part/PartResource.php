<?php

namespace App\Http\Resources\Part;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="PartResource",
 *     type="object",
 *     required={"id", "part_number_id", "task_id", "appliance_id", "distributor_id", "user_id", "status_id", "qnt", "dealer_price", "retail_price"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="The unique identifier for the part.",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="part_number_id",
 *         type="integer",
 *         description="The ID of the part number.",
 *         example=101
 *     ),
 *     @OA\Property(
 *         property="task_id",
 *         type="integer",
 *         description="The ID of the associated task.",
 *         example=202
 *     ),
 *     @OA\Property(
 *         property="appliance_id",
 *         type="integer",
 *         description="The ID of the associated appliance.",
 *         example=303
 *     ),
 *     @OA\Property(
 *         property="distributor_id",
 *         type="integer",
 *         description="The ID of the distributor.",
 *         example=404
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="The ID of the user associated with the part.",
 *         example=505
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="The ID of the part status.",
 *         example=606
 *     ),
 *     @OA\Property(
 *         property="qnt",
 *         type="integer",
 *         description="The quantity of parts.",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="dealer_price",
 *         type="number",
 *         format="float",
 *         description="The dealer price of the part.",
 *         example=100.0
 *     ),
 *     @OA\Property(
 *         property="retail_price",
 *         type="number",
 *         format="float",
 *         description="The retail price of the part.",
 *         example=150.0
 *     ),
 *     @OA\Property(
 *         property="distributor_name",
 *         type="string",
 *         maxLength=255,
 *         description="The name of the distributor.",
 *         example="Distributor Inc."
 *     ),
 *     @OA\Property(
 *         property="part_description",
 *         type="string",
 *         description="A description of the part.",
 *         example="A high-quality part for repair."
 *     ),
 *     @OA\Property(
 *         property="distributor_invoice",
 *         type="string",
 *         description="The distributor's invoice number.",
 *         example="INV-123456"
 *     ),
 *     @OA\Property(
 *         property="eta",
 *         type="string",
 *         format="date",
 *         description="The estimated time of arrival of the part.",
 *         example="2024-08-01"
 *     )
 * )
 */
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
