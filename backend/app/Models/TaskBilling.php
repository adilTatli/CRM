<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
