<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="TaskBilling",
 *     description="Model representing billing information for tasks",
 *     required={"task_id", "labor_cost", "parts_cost", "other_cost", "tax_rate", "total_cost"},
 *     @OA\Property(property="id", type="integer", description="Unique identifier of the billing entry"),
 *     @OA\Property(property="task_id", type="integer", description="ID of the related task"),
 *     @OA\Property(property="labor_cost", type="number", format="float", description="Cost of labor"),
 *     @OA\Property(property="parts_cost", type="number", format="float", description="Cost of parts"),
 *     @OA\Property(property="other_cost", type="number", format="float", description="Other associated costs"),
 *     @OA\Property(property="tax_rate", type="number", format="float", description="Tax rate applied"),
 *     @OA\Property(property="total_cost", type="number", format="float", description="Total cost including tax"),
 *     @OA\Property(property="unpaid_amount", type="number", format="float", description="Amount that remains unpaid"),
 *     @OA\Property(property="invoice_number", type="string", description="Invoice number"),
 *     @OA\Property(property="billed_job_note", type="string", description="Notes related to the billed job"),
 *     @OA\Property(property="started_at", type="string", format="date-time", description="Timestamp when the billing was started"),
 *     @OA\Property(property="appointment_at", type="string", format="date-time", description="Scheduled appointment time"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Timestamp when the billing entry was created"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Timestamp when the billing entry was last updated")
 * )
 */
class TaskBilling extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'labor_cost',
        'parts_cost',
        'other_cost',
        'tax_rate',
        'total_cost',
        'unpaid_amount',
        'invoice_number',
        'billed_job_note',
        'started_at',
        'appointment_at',
    ];

    /**
     * @OA\Property(
     *     property="task",
     *     description="The task associated with this billing entry",
     *     ref="#/components/schemas/Task"
     * )
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
