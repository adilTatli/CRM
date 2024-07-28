<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\CustomerPhoneRequest;
use App\Http\Resources\Common\CustomerPhoneResource;
use App\Models\CustomerPhone;
use App\Models\Task;
use App\Traits\Task\HandlesResourceTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CustomerPhoneController extends Controller
{
    use HandlesResourceTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerPhoneRequest $request, Task $task): JsonResponse
    {
        return $this->handleStore($request, CustomerPhone::class,
            CustomerPhoneResource::class, 'Customer phone', [
            'task_id' => $task->id,
            'phone_number' => $request->input('phone_number'),
            'note' => $request->input('note'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerPhoneRequest $request, Task $task, CustomerPhone $customerPhone): JsonResponse
    {
        return $this->handleUpdate($request, CustomerPhoneResource::class,
            'Customer phone', $customerPhone, $task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task, CustomerPhone $customerPhone): JsonResponse
    {
        return $this->handleDestroy('Customer phone', $customerPhone, $task);
    }
}
