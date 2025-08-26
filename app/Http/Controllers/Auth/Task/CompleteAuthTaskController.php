<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Task;

use App\Actions\User\Task\CompleteTask;
use App\Http\Requests\CompleteAuthTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class CompleteAuthTaskController
{
    public function __construct(public CompleteTask $complete)
    {
    }

    public function __invoke(Task $task, Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$this->complete->handle($task, $user)) {
            return response()->json(['message' => 'Task not completed.'], 400);
        }

        return response()->json(['message' => 'Task completed successfully.']);
    }
}
