<?php

namespace App\Repositories\Interface;

use App\Models\Building;

interface BuildingRepositoryInterface
{
    public function getAll();
    public function getUnitsByBuilding(Building $building);

}
