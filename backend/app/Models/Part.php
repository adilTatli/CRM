<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_number_id',
        'task_id',
        'appliance_id',
        'distributor_id',
        'user_id',
        'status_id',
        'qnt',
        'dealer_price',
        'retail_price',
        'distributor_name',
        'part_description',
        'distributor_invoice',
        'eta',
    ];

    public function partNumber()
    {
        return $this->belongsTo(PartNumber::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function appliance()
    {
        return $this->belongsTo(Appliance::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(PartStatus::class);
    }
}
