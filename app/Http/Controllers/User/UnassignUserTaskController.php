<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Actions\User\UnassignUserTask;
use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\JsonResponse;

final class UnassignUserTaskController extends Controller
{
    public function __construct(public UnassignUserTask $unassign) {}

    public function __invoke(User $user, Task $task): JsonResponse
    {
        $unassigned = $this->unassign->handle($task, $user);

        if ($unassigned) {
            return response()->json(['message' => 'Task unassigned successfully.']);
        }

        return response()->json(['message' => 'Task not unassigned.'], 400);
    }
}
