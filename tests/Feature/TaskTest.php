<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_sees_only_own_tasks(): void
    {
        $me = User::factory()->create();
        $other = User::factory()->create();
        Task::factory()->for($me)->create(['title' => 'My task']);
        Task::factory()->for($other)->create(['title' => 'Not my task']);

        $this->actingAs($me)->get('/tasks')
            ->assertOk()
            ->assertSee('My task')
            ->assertDontSee('Not my task');
    }

    public function test_user_can_add_a_task(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', ['title' => 'Write Dockerfile'])
            ->assertRedirect('/tasks');

        $this->assertDatabaseHas('tasks', ['user_id' => $user->id, 'title' => 'Write Dockerfile']);
    }

    public function test_title_is_required(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post('/tasks', ['title' => ''])
            ->assertSessionHasErrors('title');
    }

    public function test_user_can_mark_task_done(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['is_done' => false]);

        $this->actingAs($user)->patch("/tasks/{$task->id}/toggle");

        $this->assertTrue($task->fresh()->is_done);
    }

    public function test_user_cannot_delete_someone_elses_task(): void
    {
        $task = Task::factory()->create();
        $intruder = User::factory()->create();

        $this->actingAs($intruder)->delete("/tasks/{$task->id}")->assertForbidden();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
