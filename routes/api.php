<?php

use App\Http\Controllers\BuildingController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('buildings', [BuildingController::class, 'index']);
Route::get('buildings/{building}/units', [BuildingController::class, 'units']);
Route::get('buildings/{building}/tasks', [BuildingController::class, 'tasks']);

Route::get('tasks', [TaskController::class, 'index']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::post('/tasks/{task}/comments', [CommentController::class, 'store']);
