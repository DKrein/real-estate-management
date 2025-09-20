<?php

use App\Http\Controllers\BuildingController;
use Illuminate\Support\Facades\Route;

Route::get('buildings', [BuildingController::class, 'index']);
Route::get('buildings/{building}/units', [BuildingController::class, 'units']);
