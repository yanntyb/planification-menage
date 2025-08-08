<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\User\AssignUserTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class AssignUserTaskController
{
    public function __construct(public AssignUserTask $assign) {}

    public function __invoke(User $user, Task $task): JsonResponse
    {
        $assigned = $this->assign->handle($task->id, $user->id);

        if ($assigned) {
            return response()->json(['message' => 'Task assigned successfully.']);
        }

        return response()->json(['message' => 'Task not assigned.'], 400);
    }
}
