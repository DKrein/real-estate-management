<?php

namespace App\Repositories;

use App\Models\Building;
use App\Repositories\Interface\BuildingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BuildingRepository implements BuildingRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAll(): Collection
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

    /**
     * @param Building $building
     * @param array $filters
     * @return Collection
     */
    public function getBuildingTasksWithFilters(Building $building, array $filters = []): Collection
    {
        $query = $building->tasks()->with('comments');

        foreach ($filters as $field => $value) {
            if (empty($value)) {
                continue;
            }

            switch ($field) {
                case 'status':
                    $query->where('status', $value);
                    break;
                case 'assigned_user_id':
                    $query->where('assigned_user_id', $value);
                    break;
                case 'created_from':
                    $query->whereDate('created_at', '>=', $value);
                    break;
                case 'created_to':
                    $query->whereDate('created_at', '<=', $value);
                    break;
            }
        }

        return $query->get();
    }
}
