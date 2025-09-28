<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Dto\TaskDto;
use App\Models\Dto\TaskStatsDto;
use App\Models\Services\TaskService;
use App\Models\Task;
use Illuminate\Http\Response;

class TaskController
{
    public function index()
    {
        $tasks = TaskService::getTasks();

        $tasks = TaskService::paginate($tasks);

        return response()
            ->json([
                'response' => $tasks,
                'status' => Response::HTTP_OK
            ],
                Response::HTTP_OK
        );
    }

    public function find(int $id)
    {
        $task = TaskService::findTask($id);

        return response()->json([
            'task' => $task,
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }

    public function create(TaskRequest $request)
    {
        $requestData = $request->validated();
        $task = TaskService::createTask(TaskDto::fromArray($requestData));

        return response()
            ->json([
                'task' => $task,
                'status' => Response::HTTP_CREATED
            ],
            Response::HTTP_CREATED
        );
    }

    public function update(int $id, TaskUpdateRequest $request)
    {
        $task = TaskService::findTask($id);
        $requestData = $request->validated();

        $task = TaskDto::patch($task, $requestData);
        $task = TaskService::save($task);

        return response()
            ->json([
                'task' => $task,
                'status' => Response::HTTP_OK
            ],
        Response::HTTP_OK
        );
    }

    public function delete(int $id)
    {
        $task = TaskService::findTask($id);
        TaskService::delete($task);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function statistics()
    {
        $stats = TaskStatsDto::fromQuery(Task::query());

        return response()->json([
            'stats' => $stats->getFormattedResponse(),
            'status' => Response::HTTP_OK
        ], Response::HTTP_OK);
    }
}
