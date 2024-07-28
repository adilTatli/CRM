<?php

namespace App\Repositories;

use App\Models\Task;

class TaskRepository implements TaskRepositoryInterface
{
    public function findById(string $id): ?Task
    {
        return Task::with([
            'insurance',
            'status',
            'notes',
            'phones',
            'files',
            'applianceLists',
            'receivedPayments',
            'technicians',
            'parts'
        ])->find($id);
    }
}
