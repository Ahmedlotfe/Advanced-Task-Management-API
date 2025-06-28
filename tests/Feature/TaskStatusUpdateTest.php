<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function it_can_update_task_status_to_in_progress()
    {
        $task = Task::factory()->create(['status' => 'Pending']);

        $response = $this->putJson("/api/tasks/{$task->id}/status", ['status' => 'In Progress']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'In Progress',
        ]);
    }

    /** @test */
    public function it_cannot_update_status_to_completed_without_in_progress()
    {
        $task = Task::factory()->create(['status' => 'Pending']);

        $response = $this->putJson("/api/tasks/{$task->id}/status", ['status' => 'Completed']);

        $response->assertStatus(400);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'Pending',
        ]);
    }
}
