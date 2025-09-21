<?php

namespace App\Http\Controllers;

use App\Service\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController
{

    public function __construct(private readonly TaskService $taskService)
    {
    }

    /**
     * List all tasks.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tasks = $this->taskService->getAllTasks();
        return response()->json($tasks);
    }

    /**
     * Store a new task
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_id'     => 'nullable|exists:units,id',
            'assigned_user_id' => 'nullable|exists:users,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'status'      => 'required|in:open,in_progress,completed,rejected',
        ]);

        $task = $this->taskService->create($validated);

        return response()->json($task, 201);
    }
}
