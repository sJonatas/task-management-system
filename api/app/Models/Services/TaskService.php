<?php

declare(strict_types = 1);

namespace App\Models\Services;

use App\Models\Dto\TaskDto;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TaskService
{
    public static function getTasks(int $numPages = 10)
    {
        return Task::query();
    }

    public static function paginate(Builder $query, int $numPages = 10)
    {
        return $query->paginate($numPages);
    }

    public static function filter(Builder $taskQuery, array $filters): void
    {
        collect($filters)->each(function ($value, $key) use ($taskQuery) {
            if (in_array($key, (new Task)->fillable)) {
                $taskQuery->where($key, 'like', "%{$value}%");
            }
        });
    }

    /**
     * @param $id
     * @return Task
     */
    public static function findTask($id): TaskDto
    {
        try {
            return TaskDto::fromModel(Task::query()->findOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new NotFoundHttpException('Task not found', null, 404);
        }
    }

    public static function createTask(TaskDto $data): TaskDto
    {
        $task = Task::query()->create([
            'id' => null,
            'title' => $data->title,
            'description' => $data->description,
            'status' => $data->status->value,
            'priority' => $data->priority->value,
            'dueDate' => $data->dueDate,
        ]);

        return TaskDto::fromModel($task);
    }

    public static function save(TaskDto $task): TaskDto
    {
        $taskModel = Task::query()->findOrFail($task->id);

        $taskModel->update($task->toArray());

        return TaskDto::fromModel($taskModel);
    }

    public static function delete(TaskDto $task): void
    {
        Task::query()->findOrFail($task->id)
            ->delete();
    }
}
