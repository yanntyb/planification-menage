<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\CompleteUserTask;
use App\Http\Requests\CompleteAuthTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;

final class CompleteAuthTaskController
{
    public function __construct(public CompleteUserTask $complete) {}

    public function __invoke(CompleteAuthTaskRequest $request): JsonResponse
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        /** @var Task|null $task */
        $task = $user->tasks()->find($request->task_id);

        if (! $task) {
            return response()->json(['message' => 'You are not assigned to this task'], 403);
        }

        if (! $this->complete->handle($task, $user)) {
            return response()->json(['message' => 'Task not completed.'], 400);
        }

        return response()->json(['message' => 'Task completed successfully.']);
    }
}
