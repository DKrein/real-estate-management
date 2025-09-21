<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Task;
use App\Service\CommentService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

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
    public function store(StoreCommentRequest $request, Task $task): JsonResponse
    {
        try {
            $comment = $this->commentService->create($request->validated());
            return response()->json($comment, 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Model not found',
                'message' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
