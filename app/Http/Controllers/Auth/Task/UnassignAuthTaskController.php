<?php

namespace App\Http\Controllers\Auth\Task;

use App\Actions\User\Task\UnassignTask;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class UnassignAuthTaskController extends Controller
{
    public function __construct(public UnassignTask $unassign)
    {
    }

    public function __invoke(Task $task, Request $request)
    {

        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($this->unassign->handle($task, $user)) {
            return response()->json(['message' => 'Task unassigned successfully.']);
        }

        return response()->json(['message' => 'Task not unassigned.'], 400);
    }
}
