<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CustomerPhoneResource",
 *     title="Customer Phone Resource",
 *     description="Resource schema for a customer phone record",
 *     type="object",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the customer phone record",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="phone_number",
 *         type="string",
 *         description="The phone number of the customer",
 *         example="+1234567890"
 *     ),
 *     @OA\Property(
 *         property="note",
 *         type="string",
 *         description="Optional note about the phone number",
 *         example="Preferred contact number"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the record was created",
 *         example="2024-07-28T12:34:56Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the record was last updated",
 *         example="2024-07-28T12:34:56Z"
 *     )
 * )
 */
class CustomerPhoneResource extends JsonResource
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
            'phone_number' => $this->phone_number,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
