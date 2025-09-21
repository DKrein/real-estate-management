<?php

namespace App\Repositories\Interface;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param array $data
     * @return Task
     */
    public function create(array $data): Task;
}
