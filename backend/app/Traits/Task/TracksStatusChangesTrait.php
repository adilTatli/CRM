<?php

namespace App\Traits\Task;

use App\Models\StatusChange;
use Illuminate\Support\Facades\Auth;

trait TracksStatusChangesTrait
{
    public function recordStatusChange(int $taskId, int $statusId): void
    {
        StatusChange::create([
            'task_id' => $taskId,
            'status_id' => $statusId,
            'user_id' => Auth::id(),
        ]);
    }
}
