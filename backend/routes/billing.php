<?php

use App\Http\Controllers\API\Billing\ReceivedPaymentController;
use App\Http\Controllers\API\Billing\TechnicianPayController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.billing'])->prefix('billing')->group(function () {
    Route::apiResource('payments', ReceivedPaymentController::class)
        ->except('index', 'show');

    Route::get('tasks/{task}/technicians', [TechnicianPayController::class, 'index']);
    Route::patch('tasks/{task}/technicians/{user}', [TechnicianPayController::class, 'update']);
});
