<?php

namespace App\Repositories\Interface;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

interface BuildingRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection;

    /**
     * @param Building $building
     * @return Collection
     */
    public function getUnitsByBuilding(Building $building): Collection;

    /**
     * @param Building $building
     * @return Collection
     */
    public function getTasksByBuilding(Building $building): Collection;

    /**
     * @param Building $building
     * @param array $filters
     * @return Collection
     */
    public function getBuildingTasksWithFilters(Building $building, array $filters = []): Collection;

}
