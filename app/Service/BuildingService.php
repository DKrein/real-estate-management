<?php

namespace App\Service;

use App\Models\Building;
use App\Repositories\Interface\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BuildingService
{
    public function __construct(
      private readonly BuildingRepositoryInterface $buildingRepository,
    ) {
    }

    /**
     * @return Collection
     */
    public function getAllBuildings(): Collection
    {
        return $this->buildingRepository->getAll();
    }

    /**
     * @param Building $building
     * @return Collection
     */
    public function getUnitsByBuilding(Building $building): Collection
    {
        return $this->buildingRepository->getUnitsByBuilding($building);
    }

    /**
     * @param Building $building
     * @return Collection
     */
    public function getTasksByBuilding(Building $building): Collection
    {
        return $this->buildingRepository->getTasksByBuilding($building);
    }
}
