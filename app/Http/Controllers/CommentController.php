<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
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
     * @param StoreCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {

        $comment = $this->commentService->create($request->validated());

        return response()->json($comment, 201);
    }
}
