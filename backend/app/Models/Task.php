<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
