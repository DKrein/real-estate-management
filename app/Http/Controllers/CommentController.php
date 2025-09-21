<?php

namespace App\Http\Controllers;

use App\Service\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController
{

    public function __construct(private readonly CommentService $commentService)
    {
    }

    /**
     * Store a new comment to a task
     *
     * @param Request $request
     * @param int $taskId
     * @return JsonResponse
     */
    public function store(Request $request, int $taskId): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ]);

        $validated['task_id'] = $taskId;

        $comment = $this->commentService->create($validated);

        return response()->json($comment, 201);
    }
}
