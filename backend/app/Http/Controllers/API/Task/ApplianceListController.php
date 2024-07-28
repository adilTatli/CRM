<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\ApplianceListRequest;
use App\Http\Resources\Common\ApplianceListResource;
use App\Models\ApplianceList;
use App\Models\Task;
use App\Traits\Task\HandlesResourceTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApplianceListController extends Controller
{
    use HandlesResourceTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplianceListRequest $request, Task $task): JsonResponse
    {
        try {
            $data = $request->validated();
            $data['task_id'] = $task->id;

            $applianceList = ApplianceList::create($data);

            $applianceList->load('appliance');

            return response()->json(new ApplianceListResource($applianceList), JsonResponse::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error("Error creating appliance list: " . $e->getMessage(), ['request' => $request->all()]);

            return response()->json([
                'message' => "An error occurred while creating the appliance list.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplianceListRequest $request, Task $task, ApplianceList $appliance): JsonResponse
    {
        try {
            if ($appliance->task_id !== $task->id) {
                return response()->json([
                    'message' => 'The appliance list does not belong to the specified task.',
                ], JsonResponse::HTTP_FORBIDDEN);
            }

            $appliance->update($request->validated());
            $appliance->load('appliance');

            return response()->json(new ApplianceListResource($appliance), JsonResponse::HTTP_OK);
        } catch (Exception $e) {
            Log::error("Error updating appliance list: " . $e->getMessage(), [
                'resource_id' => $appliance->id,
                'request' => $request->all(),
            ]);

            return response()->json([
                'message' => "An error occurred while updating the appliance list.",
                'error' => $e->getMessage(),
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, ApplianceList $appliance): JsonResponse
    {
        return $this->handleDestroy('Appliance list', $appliance, $task);
    }
}
