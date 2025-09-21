<?php

namespace Tests\Feature;

use App\Models\Building;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_tasks_for_a_building()
    {
        $building = Building::factory()->create();
        $task = Task::factory()->create(['building_id' => $building->id]);

        $response = $this->getJson("/api/buildings/{$building->id}/tasks");

        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $task->id]);
    }

    /** @test */
    public function it_can_create_a_task()
    {
        $building = Building::factory()->create();
        $user = User::factory()->create();

        $payload = [
            'building_id' => $building->id,
            'assigned_user_id' => $user->id,
            'title' => 'Fix Light',
            'description' => 'Replace broken lamp',
            'status' => 'open'
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Fix Light']);

        $this->assertDatabaseHas('tasks', ['title' => 'Fix Light']);
    }

    /** @test */
    public function it_requires_building_id_when_creating_task()
    {
        $payload = [
            'title' => 'Missing building',
            'status' => 'open',
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['building_id']);
    }
}
