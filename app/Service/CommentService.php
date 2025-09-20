<?php

namespace App\Service;

use App\Repositories\Interface\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
    ) {
    }
}
