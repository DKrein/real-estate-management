<?php

namespace App\Service;

use App\Models\Task;
use App\Repositories\Interface\TaskRepositoryInterface;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
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
