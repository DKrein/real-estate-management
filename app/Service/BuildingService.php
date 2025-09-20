<?php

namespace App\Service;

use App\Models\Building;
use App\Repositories\Interface\BuildingRepositoryInterface;

class BuildingService
{
    public function __construct(
      private readonly BuildingRepositoryInterface $buildingRepository,
    ) {
    }

    /**
     * @return mixed
     */
    public function getAllBuildings()
    {
        return $this->buildingRepository->getAll();
    }

    /**
     * @param Building $building
     * @return Building
     */
    public function getUnitsByBuilding(Building $building): Building
    {
        return $this->buildingRepository->getUnitsByBuilding($building);
    }
}
