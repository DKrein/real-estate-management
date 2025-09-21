<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Interface\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Task::all();
    }

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return Task::create($data);
    }
}
