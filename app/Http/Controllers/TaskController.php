<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
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
     * @param StoreTaskRequest $request
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->validated());

        return response()->json($task, 201);
    }
}
