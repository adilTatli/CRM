<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplianceList extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'model_number',
        'brand',
        'dop',
        'appl_note',
        'appliance_id',
        'task_id',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }
}
