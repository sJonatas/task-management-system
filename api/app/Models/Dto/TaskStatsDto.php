<?php

namespace App\Models\Dto;

use App\Enum\PriorityEnum;
use App\Enum\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

class TaskStatsDto
{
    public function __construct(
        public readonly int $total,
        public readonly int $pending,
        public readonly int $inProgress,
        public readonly int $completed,
        public readonly int $low,
        public readonly int $medium,
        public readonly int $high
    )
    {
    }

    public static function fromQuery(Builder $query): static
    {
        return new TaskStatsDto(
            total: $query->count(),
            pending: ($query->clone())->where(['status' => StatusEnum::Pending->value])->count(),
            inProgress: ($query->clone())->where(['status' => StatusEnum::InProgress->value])->count(),
            completed: ($query->clone())->where(['status' => StatusEnum::Completed->value])->count(),
            low: ($query->clone())->where(['priority' => PriorityEnum::Low->value])->count(),
            medium: ($query->clone())->where(['priority' => PriorityEnum::Medium->value])->count(),
            high: ($query->clone())->where(['priority' => PriorityEnum::High->value])->count()
        );
    }

    public function getFormattedResponse(): array
    {
        return [
            'totalTasks' => $this->total,
            'byStatus' => [
                'pending' => $this->pending,
                'in_progress' => $this->inProgress,
                'completed' => $this->completed,
            ],
            'byPriority' => [
                'low' => $this->low,
                'medium' => $this->medium,
                'high' => $this->high
            ]
        ];
    }
}
