<?php

use App\Http\Controllers\API\Dispatch\TaskTechnicianController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.dispatch'])->prefix('dispatch')->group(function () {
    Route::apiResource('task-technicians', TaskTechnicianController::class);
});
