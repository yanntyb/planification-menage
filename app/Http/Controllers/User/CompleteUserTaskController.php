<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\User\CompleteUserTask;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class CompleteUserTaskController extends Controller
{
    public function __construct(public CompleteUserTask $complete) {}

    public function __invoke(User $user, Task $task): JsonResponse
    {
        $completed = $this->complete->handle($task, $user);

        if ($completed) {
            return response()->json(['message' => 'Task completed successfully.']);
        }

        return response()->json(['message' => 'Task not completed.'], 400);
    }
}
