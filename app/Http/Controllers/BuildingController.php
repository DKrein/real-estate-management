<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Service\BuildingService;
use Illuminate\Http\JsonResponse;

class BuildingController extends Controller
{
    protected BuildingService $buildingService;

    public function __construct(BuildingService $buildingService)
    {
        $this->buildingService = $buildingService;
    }

    /**
     * List all buildings.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $buildings = $this->buildingService->getAllBuildings();
        return response()->json($buildings);
    }

    /**
     * List all units inside a building.
     *
     * @param Building $building
     * @return JsonResponse
     */
    public function units(Building $building): JsonResponse
    {
        $units = $this->buildingService->getUnitsByBuilding($building);
        return response()->json($units);
    }

    /**
     * List all tasks related to a building.
     *
     * @param Building $building
     * @return JsonResponse
     */
    public function tasks(Building $building): JsonResponse
    {
        $units = $this->buildingService->getTasksByBuilding($building);
        return response()->json($units);
    }
}
