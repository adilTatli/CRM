<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Task",
 *     type="object",
 *     title="Task",
 *     description="Task model",
 *     required={"work_order", "customer_name", "status_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the task"
 *     ),
 *     @OA\Property(
 *         property="work_order",
 *         type="string",
 *         description="Work order number"
 *     ),
 *     @OA\Property(
 *         property="customer_name",
 *         type="string",
 *         description="Name of the customer"
 *     ),
 *     @OA\Property(
 *         property="street",
 *         type="string",
 *         description="Street address of the customer"
 *     ),
 *     @OA\Property(
 *         property="city",
 *         type="string",
 *         description="City of the customer"
 *     ),
 *     @OA\Property(
 *         property="zip",
 *         type="string",
 *         description="ZIP code of the customer"
 *     ),
 *     @OA\Property(
 *         property="authorization",
 *         type="string",
 *         description="Authorization code"
 *     ),
 *     @OA\Property(
 *         property="insurance_id",
 *         type="integer",
 *         description="ID of the related insurance"
 *     ),
 *     @OA\Property(
 *         property="status_id",
 *         type="integer",
 *         description="ID of the task status"
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the task was created"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Timestamp of when the task was last updated"
 *     ),
 *     @OA\Property(
 *         property="status",
 *         ref="#/components/schemas/TaskStatus",
 *         description="Related status model"
 *     ),
 *     @OA\Property(
 *         property="notes",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Note"),
 *         description="List of notes associated with the task"
 *     ),
 *     @OA\Property(
 *         property="insurance",
 *         ref="#/components/schemas/Insurance",
 *         description="Related insurance model"
 *     ),
 *     @OA\Property(
 *         property="phones",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/CustomerPhone"),
 *         description="List of customer phones associated with the task"
 *     ),
 *     @OA\Property(
 *         property="applianceLists",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ApplianceList"),
 *         description="List of appliance lists associated with the task"
 *     ),
 *     @OA\Property(
 *         property="files",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/TaskFile"),
 *         description="List of files associated with the task"
 *     ),
 *     @OA\Property(
 *         property="taskBilling",
 *         ref="#/components/schemas/TaskBilling",
 *         description="Related task billing model"
 *     ),
 *     @OA\Property(
 *         property="technicians",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/User"),
 *         description="List of technicians associated with the task"
 *     ),
 *     @OA\Property(
 *         property="parts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Part"),
 *         description="List of parts associated with the task"
 *     ),
 *     @OA\Property(
 *         property="receivedPayments",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/ReceivedPayment"),
 *         description="List of received payments associated with the task"
 *     ),
 *     @OA\Property(
 *         property="statusChanges",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/StatusChange"),
 *         description="List of status changes associated with the task"
 *     )
 * )
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_order',
        'customer_name',
        'street',
        'city',
        'zip',
        'authorization',
        'insurance_id',
        'status_id',
    ];

    public function status()
    {
        return $this->belongsTo(TaskStatus::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function insurance()
    {
        return $this->belongsTo(Insurance::class);
    }

    public function phones()
    {
        return $this->hasMany(CustomerPhone::class);
    }

    public function applianceLists()
    {
        return $this->hasMany(ApplianceList::class);
    }

    public function files()
    {
        return $this->hasMany(TaskFile::class);
    }

    public function taskBilling()
    {
        return $this->hasOne(TaskBilling::class);
    }

    public function technicians()
    {
        return $this->belongsToMany(User::class, 'task_technician')
            ->withPivot('id', 'date', 'start_time', 'end_time', 'payment_amount', 'paid_at', 'payment_status')
            ->withTimestamps();
    }

    public function parts()
    {
        return $this->hasMany(Part::class);
    }

    public function receivedPayments()
    {
        return $this->hasMany(ReceivedPayment::class);
    }

    public function statusChanges()
    {
        return $this->hasMany(StatusChange::class);
    }
}
