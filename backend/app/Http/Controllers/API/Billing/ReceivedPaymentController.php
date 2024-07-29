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

/**
 * @OA\Tag(
 *     name="Received Payments",
 *     description="API Endpoints for managing received payments"
 * )
 */
class ReceivedPaymentController extends Controller
{
    use BillingTrait;

    /**
     * @OA\Post(
     *     path="/api/billing/payments",
     *     operationId="storeReceivedPayment",
     *     tags={"Received Payments"},
     *     summary="Store a newly created received payment",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ReceivedPaymentRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Payment added successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment added successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to store payment.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to store payment.")
     *         )
     *     )
     * )
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
     * @OA\Put(
     *     path="/api/billing/payments/{payment}",
     *     operationId="updateReceivedPayment",
     *     tags={"Received Payments"},
     *     summary="Update an existing received payment",
     *     @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the received payment"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ReceivedPaymentRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment updated successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment updated successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update payment.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to update payment.")
     *         )
     *     )
     * )
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
     * @OA\Delete(
     *     path="/api/billing/payments/{payment}",
     *     operationId="deleteReceivedPayment",
     *     tags={"Received Payments"},
     *     summary="Delete an existing received payment",
     *     @OA\Parameter(
     *         name="payment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the received payment"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Payment deleted successfully.",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Payment deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete payment.",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Failed to delete payment.")
     *         )
     *     )
     * )
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
