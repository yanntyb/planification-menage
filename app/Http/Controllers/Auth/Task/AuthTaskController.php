<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth\Task;

use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class AuthTaskController
{
    /**
     * @return AnonymousResourceCollection<TaskResource>
     */
    public function __invoke(Request $request): AnonymousResourceCollection
    {
        return TaskResource::collection($request->user()->tasks ?? []);
    }
}
