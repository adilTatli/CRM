<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
