<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Unit;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildingControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_buildings()
    {
        $buildings = Building::factory()->count(3)->create();

        $response = $this->getJson('/api/buildings');

        $response->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonFragment([
                'id' => $buildings[0]->id,
                'name' => $buildings[0]->name
            ]);
    }

    /** @test */
    public function it_can_show_a_building_with_tasks_and_comments()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);
        $task = Task::factory()->create(['building_id' => $building->id]);
        $comment = $task->comments()->create([
            'user_id' => User::factory()->create()->id,
            'content' => 'Test comment'
        ]);

        $response = $this->getJson("/api/buildings/{$building->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $building->id])
            ->assertJsonFragment(['id' => $task->id])
            ->assertJsonFragment(['content' => 'Test comment']);
    }

    /** @test */
    public function it_applies_task_filters_on_show()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);
        $someUser = User::factory()->create();

        $task1 = Task::factory()->create([
            'building_id' => $building->id,
            'status' => 'open',
            'assigned_user_id' => $someUser->id
        ]);

        $task2 = Task::factory()->create([
            'building_id' => $building->id,
            'status' => 'completed',
            'assigned_user_id' => $owner->id
        ]);

        // Filter by status
        $response = $this->getJson("/api/buildings/{$building->id}?status=open");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task1->id])
            ->assertJsonMissing(['id' => $task2->id]);
    }

    /** @test */
    public function it_can_list_units_for_a_building()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);
        $units = Unit::factory()->count(5)->create(['building_id' => $building->id]);

        $response = $this->getJson("/api/buildings/{$building->id}/units");

        $response->assertStatus(200)
            ->assertJsonCount(5);
    }

    /** @test */
    public function it_can_list_tasks_for_a_building()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);
        $tasks = Task::factory()->count(4)->create(['building_id' => $building->id]);

        $response = $this->getJson("/api/buildings/{$building->id}/tasks");

        $response->assertStatus(200)
            ->assertJsonCount(4);
    }

    /** @test */
    public function it_filters_tasks_by_status()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);

        $taskOpen = Task::factory()->create(['building_id' => $building->id, 'status' => 'open']);
        $taskCompleted = Task::factory()->create(['building_id' => $building->id, 'status' => 'completed']);

        $response = $this->getJson("/api/buildings/{$building->id}?status=open");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $taskOpen->id])
            ->assertJsonMissing(['id' => $taskCompleted->id]);
    }

    /** @test */
    public function it_filters_tasks_by_assigned_user()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $building = Building::factory()->create(['owner_id' => $owner->id]);

        $task1 = Task::factory()->create(['building_id' => $building->id, 'assigned_user_id' => $user1->id]);
        $task2 = Task::factory()->create(['building_id' => $building->id, 'assigned_user_id' => $user2->id]);

        $response = $this->getJson("/api/buildings/{$building->id}?assigned_user_id={$user1->id}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task1->id])
            ->assertJsonMissing(['id' => $task2->id]);
    }

    /** @test */
    public function it_filters_tasks_by_created_date_range()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $building = Building::factory()->create(['owner_id' => $owner->id]);

        $assignedUser = User::factory()->create();

        $task1 = Task::factory()->create([
            'building_id' => $building->id,
            'assigned_user_id' => $assignedUser->id,
            'created_at' => now()->subDays(10)
        ]);

        $task2 = Task::factory()->create([
            'building_id' => $building->id,
            'assigned_user_id' => $assignedUser->id,
            'created_at' => now()->subDays(2)
        ]);

        $task3 = Task::factory()->create([
            'building_id' => $building->id,
            'assigned_user_id' => $assignedUser->id,
            'created_at' => now()->subDays(200)
        ]);

        $from = now()->subDays(3)->format('Y-m-d');
        $to = now()->format('Y-m-d');

        $response = $this->getJson("/api/buildings/{$building->id}?created_from={$from}&created_to={$to}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task1->id])
            ->assertJsonFragment(['id' => $task2->id])
            ->assertJsonMissing(['id' => $task3->id]);
    }

    /** @test */
    public function it_applies_multiple_filters_simultaneously()
    {
        $owner = User::factory()->create(['role' => 'owner']);
        $user = User::factory()->create();
        $someUser = User::factory()->create();

        $building = Building::factory()->create(['owner_id' => $owner->id]);

        $taskMatch = Task::factory()->create([
            'building_id' => $building->id,
            'status' => 'open',
            'assigned_user_id' => $user->id,
            'created_at' => now()->subDays(1)
        ]);

        $taskNoMatch = Task::factory()->create([
            'building_id' => $building->id,
            'status' => 'completed',
            'assigned_user_id' => $someUser->id,
            'created_at' => now()->subDays(10)
        ]);

        $from = now()->subDays(2)->format('Y-m-d');
        $to = now()->format('Y-m-d');

        $response = $this->getJson("/api/buildings/{$building->id}?status=open&assigned_user_id={$user->id}&created_from={$from}&created_to={$to}");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $taskMatch->id])
            ->assertJsonMissing(['id' => $taskNoMatch->id]);
    }
}
