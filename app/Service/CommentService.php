<?php

namespace App\Service;

use App\Models\Comment;
use App\Repositories\Interface\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
    ) {
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        return $this->commentRepository->create($data);
    }
}
