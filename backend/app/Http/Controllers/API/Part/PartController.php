<?php

namespace App\Http\Controllers\API\Part;

use App\Http\Controllers\Controller;
use App\Http\Requests\Part\PartRequest;
use App\Http\Resources\Part\PartResource;
use App\Models\Part;
use App\Models\PartNumber;
use App\Models\ReceivedPayment;
use App\Models\TaskBilling;
use App\Traits\Billing\BillingTrait;
use Exception;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class PartController extends Controller
{
    use BillingTrait;

    /**
     * Store a newly created resource in storage.
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
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
