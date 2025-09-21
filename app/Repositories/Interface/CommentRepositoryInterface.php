<?php

namespace App\Repositories\Interface;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment;
}
