<?php

use App\Http\Controllers\API\Manager\TaskStatusHistoryController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.manager'])->prefix('manager')->group(function () {
    Route::get('tasks/{task}/status-history', [TaskStatusHistoryController::class, 'index']);
});
