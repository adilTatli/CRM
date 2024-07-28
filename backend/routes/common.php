<?php

use App\Http\Controllers\API\Common\TaskController;
use Illuminate\Support\Facades\Route;

Route::prefix('common')->group(function () {
    Route::apiResource('tasks', TaskController::class)->except('store', 'destroy');
});
