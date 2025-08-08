<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Task\CreateTask;
use App\Actions\Task\DeleteTask;
use App\Actions\Task\UpdateTaskPoint;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class TaskController extends Controller
{
    /**
     * @return AnonymousResourceCollection<TaskResource>
     */
    public function index(): AnonymousResourceCollection
    {
        return TaskResource::collection(Task::all());
    }

    public function store(StoreTaskRequest $request): TaskResource
    {
        $task = app(CreateTask::class)->handle($request->title);

        return new TaskResource($task);
    }

    public function show(Task $task): TaskResource
    {
        return new TaskResource($task);
    }

    public function update(UpdateTaskRequest $request, Task $task): void
    {
        app(UpdateTaskPoint::class)->handle($task->id, $request->points);
    }

    public function destroy(Task $task): Response
    {
        $deleted = app(DeleteTask::class)->handle($task->id);

        if ($deleted) {
            return response()->noContent();
        }

        return response(null, 500);
    }
}
