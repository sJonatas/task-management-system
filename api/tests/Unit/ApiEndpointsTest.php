<?php

namespace Tests\Unit;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use App\Models\Dto\TaskDto;
use App\Models\Services\TaskService;
use App\Models\Task;
use Tests\TestCase;

class ApiEndpointsTest extends TestCase
{
    public function testGetAllTasks()
    {
        $this->getJson('/api/tasks')
            ->assertStatus(200)
            ->assertJsonStructure([
                'response' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'links'
                ]
            ]);
    }

    public function testGetTask()
    {
        $task = Task::factory()->create();

        $this->getJson("/api/tasks/{$task->id}")
            ->assertStatus(200)
            ->assertJsonPath('task.id', $task->id);
    }

    public function testCreateTask()
    {
        $this->postJson("/api/tasks", [
            'title' => 'Test task',
            'description' => 'Test task description',
            'status' => StatusEnum::InProgress,
            'priority' => PriorityEnum::High,
        ])
            ->assertStatus(201)
            ->assertJsonPath('task.title', 'Test task')
            ->assertJsonPath('task.description', 'Test task description')
            ->assertJsonPath('task.status', StatusEnum::InProgress->value)
            ->assertJsonPath('task.priority', PriorityEnum::High->value);
    }

    public function testUpdateTask()
    {
        $task = Task::factory()->create();

        $this->patchJson("/api/tasks/{$task->id}", ['title' => 'Updated task'])
            ->assertStatus(200)
            ->assertJsonPath('task.title', 'Updated task');
    }

    public function testDeleteTask()
    {
        $this->expectExceptionCode(404);
        $task = Task::factory()->create();

        $this->deleteJson("/api/tasks/{$task->id}")
            ->assertStatus(204);

        TaskService::findTask($task->id);
    }
}
