<?php

declare(strict_types = 1);

namespace Tests\Unit;

use App\Enum\PriorityEnum;
use App\Models\Dto\TaskDto;
use App\Models\Task;
use PHPUnit\Framework\TestCase;

class TaskDtoTest extends TestCase
{
    public function test_task_dto_creation(): void
    {
        $dto = new \App\Models\Dto\TaskDto(
            null,
            'title',
            null,
            \App\Enum\StatusEnum::Pending,
            \App\Enum\PriorityEnum::Medium,
            null,
            null,
            null
        );

        $this->assertEquals('title', $dto->title);
        $this->assertEquals(\App\Enum\StatusEnum::Pending->value, $dto->status->value);
        $this->assertEquals(\App\Enum\PriorityEnum::Medium->value, $dto->priority->value);
    }

    public function test_task_dto_creation_from_model(): void
    {
        $task = new Task([
            'title' => 'title',
            'status' => \App\Enum\StatusEnum::Pending->value,
            'priority' => \App\Enum\PriorityEnum::Medium->value,
        ]);

        $dto = TaskDto::fromModel($task);

        $this->assertEquals($task->title, $dto->title);
        $this->assertEquals($task->status->value, $dto->status->value);
        $this->assertEquals($task->priority->value, $dto->priority->value);
    }

    public function test_test_dto_patch(): void
    {
        $dto = TaskDto::fromArray([
            'title' => 'title',
            'status' => \App\Enum\StatusEnum::Pending,
            'priority' => \App\Enum\PriorityEnum::Medium,
        ]);

        $patched = TaskDto::patch($dto, [
            'title' => 'updated title',
            'priority' => \App\Enum\PriorityEnum::Low,
        ]);

        $this->assertEquals('updated title', $patched->title);
        $this->assertEquals(PriorityEnum::Low->value, $patched->priority->value);
        $this->assertNull($patched->dueDate);
    }
}
