<?php

use App\Http\Controllers\API\Part\PartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['permission:view.parts'])->group(function () {
    Route::apiResource('parts', PartController::class);
});
