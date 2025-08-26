<?php

declare(strict_types=1);

use App\Actions\User\Task\AssignTask;
use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\TaskCannotBeAssignedException;
use App\Models\Task;
use App\Models\User;

describe(AssignTask::class, function () {
    it('assign task to user', function () {
        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTask::class)->handle($task, $user);

        expect($task->users()->first()->id)->toBe($user->id)
            ->and($user->tasks()->first()->id)->toBe($task->id);
    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTask::class)->handle($task, $user);

        Event::assertDispatched(fn (TaskAssignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('throw on assign task without point', function () {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $this->assertThrows(fn () => app(AssignTask::class)->handle($task, $user), TaskCannotBeAssignedException::class);
    });
});
