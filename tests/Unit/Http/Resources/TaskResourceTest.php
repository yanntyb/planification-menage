<?php

declare(strict_types=1);

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;

describe(TaskResource::class, function () {
    it('include last completion date', function () {
        $user = User::factory()->create();
        $this->freezeTime(function (Carbon\Carbon $now) use ($user) {
            $task = Task::factory()->completed($user)->create();
            $resource = TaskResource::make($task)->resolve();

            expect($resource)->last_completed_at->toBe($now->toString());
        });
    });
});
