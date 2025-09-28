<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use App\Models\Dto\TaskDto;
use App\Models\Services\TaskService;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class TaskServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateTask(): void
    {
        $title = fake()->text(100);
        $description = fake()->text(500);
        $status = StatusEnum::Pending;
        $priority = PriorityEnum::Medium;
        $date = Carbon::now()->addDays(10);
        $now = Carbon::now()->format('Y-m-d H:i:s');

        $task = TaskService::createTask(new TaskDto(
            null,
            $title,
            $description,
            $status,
            $priority,
            $date,
            $now,
            $now
        ));

        $this->assertInstanceOf(TaskDto::class, $task);
        $this->assertEquals($title, $task->title);
        $this->assertEquals($description, $task->description);
        $this->assertEquals($status, $task->status);
        $this->assertEquals($priority, $task->priority);
        $this->assertEquals($date, $task->dueDate);
        $this->assertEquals($now, $task->createdAt);
        $this->assertEquals($now, $task->updatedAt);
    }


    public function testFindTaskById(): void
    {
        $task = Task::factory()->create();

        $foundTask = TaskService::findTask($task->id);

        $this->assertEquals($task->id, $foundTask->id);
    }

    public function testFilters()
    {
        $task = Task::factory()->create(['title' => 'testing some filter']);
        $query = Task::query();

        $filters = [
            'title' => 'some',
        ];

        TaskService::filter($query, $filters);

        $this->assertCount(1, $query->get());

        TaskService::filter($query, ['title' => 'invalid matching']);

        $this->assertCount(0, $query->get());
    }

    public function testGetPaginateTasks(): void
    {
        Task::factory(19)->create();
        $tasks = TaskService::getTasks();
        $tasks = TaskService::paginate($tasks )->toArray();

        $this->assertArrayHasKey('current_page', $tasks);
        $this->assertArrayHasKey('data', $tasks);
        $this->assertArrayHasKey('first_page_url', $tasks);
        $this->assertArrayHasKey('from', $tasks);
        $this->assertArrayHasKey('last_page', $tasks);
        $this->assertArrayHasKey('last_page_url', $tasks);
        $this->assertArrayHasKey('links', $tasks);
        $this->assertArrayHasKey('next_page_url', $tasks);
        $this->assertArrayHasKey('path', $tasks);
        $this->assertArrayHasKey('per_page', $tasks);
        $this->assertArrayHasKey('prev_page_url', $tasks);
        $this->assertArrayHasKey('to', $tasks);
        $this->assertArrayHasKey('total', $tasks);

        $this->assertIsArray($tasks['data']);
        $this->assertIsArray($tasks['links']);
        $this->assertEquals(10, $tasks['per_page']);
        $this->assertEquals(19, $tasks['total']);
        $this->assertEquals(2, $tasks['last_page']);
    }

    public function testGetTaskById404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        TaskService::findTask(-1);
    }

    public function testDeleteTask(): void
    {
        $this->expectExceptionCode(404);

        $task = Task::factory()->create();
        $taskDto = TaskDto::fromModel($task);

        TaskService::delete($taskDto);
        TaskService::findTask($task->id);
    }

    public function testSaveTask(): void
    {
        $task = Task::factory()->create();
        $task = TaskDto::patch(TaskDto::fromModel($task), ['title' => 'updated title']);
        $task = TaskService::save($task);

        $this->assertEquals('updated title', $task->title);
    }
}
