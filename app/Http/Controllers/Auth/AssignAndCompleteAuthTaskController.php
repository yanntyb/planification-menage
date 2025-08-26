<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\Task\AssignTask;
use App\Actions\User\Task\CompleteTask;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;

class AssignAndCompleteAuthTaskController extends Controller
{
    public function __construct(
        public AssignTask $assign,
        public CompleteTask $complete,
    )
    {}

    public function __invoke(Task $task, Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if(!$this->assign->handle($task, $user)) {
            return response()->json(['message' => 'Error while completing task'], 400);
        }

        if (!$this->complete->handle($task, $user)) {
            return response()->json(['message' => 'Error while completing task'], 400);
        }

        return response()->json(['message' => 'Task completed successfully.']);
    }
}
