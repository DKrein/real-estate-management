<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $building = Building::factory()->create();
        $assignedUser = User::factory()->create();

        return [
            'building_id' => $building->id,
            'unit_id' => null,
            'assigned_user_id' => $assignedUser->id,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['open', 'in_progress', 'completed', 'rejected']),
        ];
    }
}
