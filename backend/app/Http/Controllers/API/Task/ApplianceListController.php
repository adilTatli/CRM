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

/**
 * @OA\Tag(
 *     name="Task/ApplianceList",
 *     description="Operations related to appliance lists"
 * )
 */
class ApplianceListController extends Controller
{
    use HandlesResourceTrait;

    /**
     * @OA\Post(
     *     path="/api/task/tasks/{task}/appliances",
     *     summary="Store a newly created appliance list",
     *     tags={"Task/ApplianceList"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to which the appliance list belongs"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ApplianceListRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Appliance list created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApplianceListResourceCommon")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/task/tasks/{task}/appliances/{appliance}",
     *     summary="Update the specified appliance list",
     *     tags={"Task/ApplianceList"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to which the appliance list belongs"
     *     ),
     *     @OA\Parameter(
     *         name="applianceList",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the appliance list to update"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/ApplianceListRequest")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance list updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ApplianceListResourceCommon")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, appliance list does not belong to the specified task"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/task/tasks/{task}/appliances/{appliance}",
     *     summary="Remove the specified appliance list",
     *     tags={"Task/ApplianceList"},
     *     @OA\Parameter(
     *         name="task",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the task to which the appliance list belongs"
     *     ),
     *     @OA\Parameter(
     *         name="applianceList",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the appliance list to delete"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Appliance list deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Forbidden, appliance list does not belong to the specified task"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy(Task $task, ApplianceList $appliance): JsonResponse
    {
        return $this->handleDestroy('Appliance list', $appliance, $task);
    }
}
