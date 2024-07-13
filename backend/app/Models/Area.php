<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'schedule_technician', 'area_id', 'schedule_id')
            ->withTimestamps();
    }
}
