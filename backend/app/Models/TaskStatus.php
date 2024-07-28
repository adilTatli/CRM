<?php

namespace App\Models;

use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public static function allStatuses()
    {
        return array_map(fn($status) => $status->value, TaskStatusEnum::cases());
    }

    public function tasks()
    {
        return $this->HasMany(Task::class);
    }

    public function statusChanges()
    {
        return $this->hasMany(StatusChange::class, 'status_id');
    }
}
