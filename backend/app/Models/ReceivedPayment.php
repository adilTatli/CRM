<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ReceivedPayment
 *
 * @OA\Schema(
 *     description="Model representing a payment received for a task.",
 *     type="object",
 *     title="ReceivedPayment",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="Unique identifier for the received payment."
 *     ),
 *     @OA\Property(
 *         property="task_id",
 *         type="integer",
 *         description="Identifier of the associated task."
 *     ),
 *     @OA\Property(
 *         property="payment",
 *         type="number",
 *         format="float",
 *         description="Amount of payment received."
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         enum={"check", "cash", "credit card", "eft", "warranty", "other"},
 *         description="Status of the payment."
 *     ),
 *     @OA\Property(
 *         property="pay_doc",
 *         type="string",
 *         description="Document related to the payment, if any."
 *     ),
 *     @OA\Property(
 *         property="date_received",
 *         type="string",
 *         format="date",
 *         description="Date when the payment was received."
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="Identifier of the user who received the payment."
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="string",
 *         description="Additional notes regarding the payment."
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the record was created."
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp when the record was last updated."
 *     )
 * )
 */
class ReceivedPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'payment',
        'payment_status',
        'pay_doc',
        'date_received',
        'user_id',
        'notes'
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
