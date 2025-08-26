<?php

namespace App\Http\Controllers\Auth\Task;

use App\Actions\User\Task\AssignTask;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignAuthTaskController extends Controller
{
    public function __construct(public AssignTask $assign)
    {
    }

    public function __invoke(Task $task, Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $assigned = $this->assign->handle($task, $user);

        if ($assigned) {
            return response()->json(['message' => 'Task assigned successfully.']);
        }

        return response()->json(['message' => 'Task not assigned.'], 400);
    }
}
