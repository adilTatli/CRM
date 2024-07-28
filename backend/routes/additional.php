<?php

use App\Http\Controllers\API\Additional\ApplianceController;
use App\Http\Controllers\API\Additional\AreaController;
use App\Http\Controllers\API\Additional\DistributorController;
use App\Http\Controllers\API\Additional\InsuranceController;
use App\Http\Controllers\API\Additional\ScheduleController;
use App\Http\Controllers\API\Additional\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.additional'])->prefix('additional')->group(function () {
    Route::apiResources([
        'users' => UserController::class,
        'appliances' => ApplianceController::class,
        'distributors' => DistributorController::class,
        'insurances' => InsuranceController::class,
        'areas' => AreaController::class,
        'schedules' => ScheduleController::class,
    ]);
});
