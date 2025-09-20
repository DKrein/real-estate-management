<?php

namespace App\Service;

use App\Repositories\Interface\TaskRepositoryInterface;

class TaskService
{
    public function __construct(
        private readonly TaskRepositoryInterface $taskRepository,
    ) {
    }
}
