<?php

declare(strict_types = 1);

namespace App\Models\Dto;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use App\Models\Task;
use Carbon\Carbon;

class TaskDto
{
    public function __construct(
        public readonly int|null $id,
        public readonly string $title,
        public readonly string|null $description,
        public readonly StatusEnum $status,
        public readonly PriorityEnum $priority,
        public readonly Carbon|string|null $dueDate,
        public readonly Carbon|string|null $createdAt,
        public readonly Carbon|string|null $updatedAt,
    ) {}

    public static function fromModel(Task $task): static
    {
        return new TaskDto(
            id: $task->id,
            title: $task->title,
            description: $task->description,
            status: $task->status,
            priority: $task->priority,
            dueDate: $task->dueDate,
            createdAt: $task->created_at,
            updatedAt: $task->updated_at
        );
    }

    public static function fromArray(array $task): static
    {
        $status = $task['status'] instanceof StatusEnum
            ? $task['status']
            : StatusEnum::tryFrom($task['status']);

        $priority = $task['priority'] instanceof PriorityEnum
            ? $task['priority']
            : PriorityEnum::tryFrom($task['priority']);

        return new TaskDto(
            id: $task['id'] ?? null,
            title: $task['title'] ?? null,
            description: $task['description'] ?? null,
            status: $status,
            priority: $priority,
            dueDate: $task['dueDate'] ?? null,
            createdAt: $task['created_at'] ?? null,
            updatedAt: $task['updated_at'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'dueDate' => $this->dueDate,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ];
    }

    public static function patch(self $dto, array $task): static
    {
        return TaskDto::fromArray([
            ...$dto->toArray(),
            ...$task,
        ]);
    }
}
