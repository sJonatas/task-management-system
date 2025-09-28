<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskRequestTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskValidationPass()
    {
        $this->postJson('/api/tasks', [
            'id' => 1,
            'title' => fake()->text(100),
            'description' => fake()->text(500),
            'status' => StatusEnum::Pending,
            'priority' => PriorityEnum::Medium,
        ])->assertValid()
        ->assertStatus(201);
    }

    public function testTaskValidationFailInvalidTitleLength()
    {
        $this->postJson('/api/tasks', [
            'id' => 1,
            'title' => fake()->text(420),
            'description' => fake()->text(500),
            'status' => StatusEnum::Pending,
            'priority' => PriorityEnum::Medium,
        ])
        ->assertStatus(500);
    }

    public function testTaskStatsGet()
    {
        Task::factory(3)->create(['status' => StatusEnum::Pending, 'priority' => PriorityEnum::Low]);
        Task::factory(1)->create(['status' => StatusEnum::Completed, 'priority' => PriorityEnum::Medium]);
        Task::factory(5)->create(['status' => StatusEnum::InProgress, 'priority' => PriorityEnum::High]);

        $this->getJson('/api/tasks/stats')
            ->assertStatus(200)
            ->assertJsonPath('stats.totalTasks', 9)
            ->assertJsonPath('stats.byStatus.pending', 3)
            ->assertJsonPath('stats.byStatus.completed', 1)
            ->assertJsonPath('stats.byStatus.in_progress', 5)
            ->assertJsonPath('stats.byPriority.low', 3)
            ->assertJsonPath('stats.byPriority.medium', 1)
            ->assertJsonPath('stats.byPriority.high', 5);
    }

    public function testInvalidRequestContentType()
    {
        $this->postJson('/api/tasks', [], ['Content-Type' => 'text/plain'])
            ->assertStatus(500)
           ->assertJsonPath('error', 'Content-Type must be application/json');
    }
}
