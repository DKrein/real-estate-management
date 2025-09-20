<?php

namespace App\Repositories;

use App\Models\Building;
use App\Repositories\Interface\BuildingRepositoryInterface;

class BuildingRepository implements BuildingRepositoryInterface
{
    public function getAll()
    {
        return Building::all();
    }

    public function getUnitsByBuilding(Building $building)
    {
        return $building->units()->get();
    }
}
