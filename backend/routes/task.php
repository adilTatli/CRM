<?php

use App\Http\Controllers\API\Task\ApplianceListController;
use App\Http\Controllers\API\Task\CustomerPhoneController;
use App\Http\Controllers\API\Task\FileController;
use App\Http\Controllers\API\Task\NoteController;
use App\Http\Controllers\API\Task\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.task'])->prefix('task')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except(['index', 'update', 'destroy']);

    Route::prefix('tasks/{task}')->group(function () {
        Route::apiResource('customer_phones', CustomerPhoneController::class)->except(['index', 'show']);
        Route::apiResource('notes', NoteController::class)->except(['index', 'show']);
        Route::apiResource('appliances', ApplianceListController::class)->except(['index', 'show']);
        Route::apiResource('files', FileController::class)->except(['index']);
    });
});
