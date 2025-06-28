<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task()
    {
        $user = User::factory()->create(); 

        $taskData = [
            'title' => 'Test Task',
            'description' => 'Test description',
            'due_date' => now()->addDays(2)->toDateString(),
            'priority' => 'Medium',
            'status' => 'Pending',
            'user_id' => $user->id, 
        ];

        $response = $this->postJson('/api/tasks', $taskData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tasks', $taskData);
    }
}
