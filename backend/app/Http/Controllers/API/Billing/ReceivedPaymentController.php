<?php

namespace App\Http\Controllers\API\Billing;

use App\Http\Controllers\Controller;
use App\Http\Requests\Billing\ReceivedPaymentRequest;
use App\Http\Resources\Billing\ReceivedPaymentResource;
use App\Models\ReceivedPayment;
use App\Traits\Billing\BillingTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ReceivedPaymentController extends Controller
{
    use BillingTrait;

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReceivedPaymentRequest $request)
    {
        try {
            $payment = ReceivedPayment::create(array_merge($request->validated(), [
                'user_id' => auth()->id(),
            ]));

            $this->recalculateTaskBilling($payment->task_id);

            return response()->json(['message' => 'Payment added successfully.'], Response::HTTP_CREATED);
        } catch (Exception $e) {
            Log::error('Failed to store payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to store payment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReceivedPaymentRequest $request, ReceivedPayment $payment)
    {
        try {
            $payment->update($request->validated());

            $this->recalculateTaskBilling($payment->task_id);

            return response()->json(['message' => 'Payment updated successfully.'], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to update payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update payment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReceivedPayment $payment)
    {
        try {
            $taskId = $payment->task_id;
            $payment->delete();

            $this->recalculateTaskBilling($taskId);

            return response()->json(['message' => 'Payment deleted successfully.'], Response::HTTP_OK);
        } catch (Exception $e) {
            Log::error('Failed to delete payment: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete payment.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
