<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_comment_for_a_task()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $payload = [
            'content' => 'This is a comment',
            'user_id' => $user->id,
        ];

        $response = $this->postJson("/api/tasks/{$task->id}/comments", $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['content' => 'This is a comment']);

        $this->assertDatabaseHas('comments', [
            'content' => 'This is a comment',
            'task_id' => $task->id,
            'user_id' => $user->id,
        ]);
    }

    /** @test */
    public function it_requires_content_when_creating_a_comment()
    {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $payload = [
            'user_id' => $user->id,
            'content' => '',
        ];

        $response = $this->postJson("/api/tasks/{$task->id}/comments", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['content']);
    }
}
