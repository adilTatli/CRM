<?php

use App\Http\Controllers\API\Additional\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.additional'])->group(function () {
    Route::apiResources([
        'users' => UserController::class,
    ]);
});
