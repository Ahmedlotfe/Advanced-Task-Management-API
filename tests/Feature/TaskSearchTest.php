<?php


namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_task_by_title()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::create([
            'title' => 'Test Task 1',
            'description' => 'Description for task 1',
            'due_date' => now()->addDays(2)->toDateString(),
            'priority' => 'Medium',
            'status' => 'Pending',
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/task/search?query=Test Task');
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Test Task 1']);
    }

    public function test_search_task_by_status()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        Task::create([
            'title' => 'Completed Task',
            'description' => 'Description for completed task',
            'status' => 'Completed',
            'due_date' => now()->addDays(1)->toDateString(),
            'priority' => 'High',
            'user_id' => $user->id,
        ]);

        Task::create([
            'title' => 'Pending Task',
            'description' => 'Description for pending task',
            'status' => 'Pending',
            'due_date' => now()->addDays(3)->toDateString(),
            'priority' => 'Medium',
            'user_id' => $user->id,
        ]);

        $response = $this->getJson('/api/task/search?query=Description');
        $response->assertStatus(200);
        $response->assertJsonFragment(['title' => 'Completed Task']);
        $response->assertJsonMissing(['title' => 'Pending Task']);
    }
}