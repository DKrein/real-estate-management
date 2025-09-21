<?php

namespace App\Service;

use App\Models\Task;
use App\Repositories\Interface\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }

    public function getAllTasks(): Collection
    {
        return $this->taskRepository->getAll();
    }

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }
}
