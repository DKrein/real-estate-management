<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interface\CommentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CommentRepository implements CommentRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Comment::all();
    }

    /**
     * @param array $data
     * @return Comment
     */
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }
}
