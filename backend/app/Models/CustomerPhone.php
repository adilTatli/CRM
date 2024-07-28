<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPhone extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'phone_number',
        'note',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
