<?php

namespace App\Http\Controllers\API\Part;

use App\Http\Controllers\Controller;
use App\Http\Requests\Part\PartRequest;
use App\Http\Resources\Part\PartResource;
use App\Models\Part;
use App\Models\PartNumber;
use App\Traits\Billing\BillingTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Part",
 *     description="Operations related to parts"
 * )
 */
class PartController extends Controller
{
    use BillingTrait;

    /**
     * @OA\Post(
     *     path="/api/parts",
     *     summary="Store a newly created part",
     *     tags={"Part"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="part_number", type="string", example="PN123"),
     *             @OA\Property(property="task_id", type="integer", example=1),
     *             @OA\Property(property="appliance_id", type="integer", example=2),
     *             @OA\Property(property="distributor_id", type="integer", example=3),
     *             @OA\Property(property="status_id", type="integer", example=4),
     *             @OA\Property(property="qnt", type="integer", example=5),
     *             @OA\Property(property="dealer_price", type="number", format="float", example=100.0),
     *             @OA\Property(property="retail_price", type="number", format="float", example=150.0),
     *             @OA\Property(property="distributor_name", type="string", example="Distributor Inc."),
     *             @OA\Property(property="part_description", type="string", example="A high-quality part for repair."),
     *             @OA\Property(property="distributor_invoice", type="string", example="INV-123456"),
     *             @OA\Property(property="eta", type="string", format="date", example="2024-08-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Part created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PartResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to store part",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to store part.")
     *         )
     *     )
     * )
     */
    public function store(PartRequest $request)
    {
        try {
            $validated = $request->validated();
            $partNumberId = $this->findOrCreatePartNumber($validated['part_number']);

            $part = Part::create(array_merge($validated, [
                'part_number_id' => $partNumberId,
                'user_id' => auth()->id()
            ]));

            $this->recalculateTaskBilling($part->task_id);

            return response()->json(new PartResource($part), Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to store part: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to store part.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/parts/{part}",
     *     summary="Update the specified part",
     *     tags={"Part"},
     *     @OA\Parameter(
     *         name="part",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the part to update"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="part_number", type="string", example="PN123"),
     *             @OA\Property(property="task_id", type="integer", example=1),
     *             @OA\Property(property="appliance_id", type="integer", example=2),
     *             @OA\Property(property="distributor_id", type="integer", example=3),
     *             @OA\Property(property="status_id", type="integer", example=4),
     *             @OA\Property(property="qnt", type="integer", example=5),
     *             @OA\Property(property="dealer_price", type="number", format="float", example=100.0),
     *             @OA\Property(property="retail_price", type="number", format="float", example=150.0),
     *             @OA\Property(property="distributor_name", type="string", example="Distributor Inc."),
     *             @OA\Property(property="part_description", type="string", example="A high-quality part for repair."),
     *             @OA\Property(property="distributor_invoice", type="string", example="INV-123456"),
     *             @OA\Property(property="eta", type="string", format="date", example="2024-08-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Part updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PartResource")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update part",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to update part.")
     *         )
     *     )
     * )
     */
    public function update(PartRequest $request, Part $part)
    {
        try {
            $validated = $request->validated();
            $partNumberId = $this->findOrCreatePartNumber($validated['part_number']);

            $part->update(array_merge($validated, [
                'part_number_id' => $partNumberId,
                'user_id' => auth()->id()
            ]));

            $this->recalculateTaskBilling($part->task_id);

            return response()->json(new PartResource($part), Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update part: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update part.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/parts/{part}",
     *     summary="Remove the specified part",
     *     tags={"Part"},
     *     @OA\Parameter(
     *         name="part",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the part to delete"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Part deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete part",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to delete part.")
     *         )
     *     )
     * )
     */
    public function destroy(Part $part)
    {
        try {
            $taskId = $part->task_id;
            $part->delete();

            $this->recalculateTaskBilling($taskId);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            Log::error('Failed to delete part: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete part.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function findOrCreatePartNumber(string $title): int
    {
        $partNumber = PartNumber::whereRaw('LOWER(title) = ?', [strtolower($title)])->first();

        if ($partNumber) {
            return $partNumber->id;
        }

        $newPartNumber = PartNumber::create(['title' => $title]);

        return $newPartNumber->id;
    }
}
