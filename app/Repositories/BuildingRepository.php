<?php

namespace App\Repositories;

use App\Models\Building;
use App\Repositories\Interface\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function getAll()
    {
        return Building::all();
    }

    /**
     * @param Building $building
     * @return Collection
     */
    public function getUnitsByBuilding(Building $building): Collection
    {
        return $building->units()->get();
    }

    /**
     * @param Building $building
     * @return Collection
     */
    public function getTasksByBuilding(Building $building): Collection
    {
        return $building->tasks()->get();
    }
}
