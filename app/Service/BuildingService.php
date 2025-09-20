<?php

namespace App\Service;

use App\Repositories\Interface\BuildingRepositoryInterface;

class BuildingService
{
    public function __construct(
      private readonly BuildingRepositoryInterface $buildingRepository,
    ) {
    }
}
