<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Service\BuildingService;
use Exception;
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
        try {
            $buildings = $this->buildingService->getAllBuildings();
            return response()->json($buildings);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List information for a specific building.
     *
     * @param Building $building
     * @return JsonResponse
     */
    public function show(Building $building): JsonResponse
    {
        try {
            $taskFilters = request()->only([
                'status',
                'assigned_user_id',
                'created_from',
                'created_to',
            ]);

            $buildingsData = $this->buildingService->getBuildingTasksAndCommentsFiltered($building, $taskFilters);
            return response()->json($buildingsData);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all units inside a building.
     *
     * @param Building $building
     * @return JsonResponse
     */
    public function units(Building $building): JsonResponse
    {
        try {
            $units = $this->buildingService->getUnitsByBuilding($building);
            return response()->json($units);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List all tasks related to a building.
     *
     * @param Building $building
     * @return JsonResponse
     */
    public function tasks(Building $building): JsonResponse
    {
        try {
            $units = $this->buildingService->getTasksByBuilding($building);
            return response()->json($units);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Something went wrong',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
