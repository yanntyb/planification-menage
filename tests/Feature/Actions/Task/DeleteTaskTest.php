<?php

declare(strict_types=1);

use App\Actions\Task\DeleteTask;
use App\Events\Task\TaskDeletedEvent;
use App\Models\Task;

describe(DeleteTask::class, function () {
    it('can delete task', function () {
        $task = Task::factory()->create();

        app(DeleteTask::class)->handle($task);

        expect($task->fresh())->exists()->toBeFalse();
    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->create();

        app(DeleteTask::class)->handle($task);

        Event::assertDispatched(fn (TaskDeletedEvent $event) => $event->id === $task->id);
    });
});
