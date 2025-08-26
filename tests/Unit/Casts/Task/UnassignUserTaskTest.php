<?php

declare(strict_types=1);

use App\Actions\User\Task\UnassignTask;
use App\Events\Task\TaskUnassignedEvent;
use App\Exceptions\Task\TaskCannotBeUnassignException;
use App\Models\Task;
use App\Models\User;

describe(UnassignTask::class, function () {
    it('unassign task user', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        app(UnassignTask::class)->handle($task, $user);

        expect($task->users()->count())->toBe(0)
            ->and($user->tasks()->count())->toBe(0);
    });

    it('fire event', function () {
        Event::fake();

        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        app(UnassignTask::class)->handle($task, $user);

        Event::assertDispatched(fn (TaskUnassignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('throw on unassign task not assigned to user', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser()->create();

        $this->assertThrows(fn () => app(UnassignTask::class)->handle($task, $user), TaskCannotBeUnassignException::class);
    });
});
