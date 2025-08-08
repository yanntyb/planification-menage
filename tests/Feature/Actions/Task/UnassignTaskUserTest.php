<?php

declare(strict_types=1);

use App\Actions\User\UnassignUserTask;
use App\Events\Task\TaskUnassignedEvent;
use App\Exceptions\Task\CannotUnassignTaskNotPreviouslyAssignedToUserException;
use App\Models\Task;
use App\Models\User;

describe(UnassignUserTask::class, function () {
    it('unassign task user', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        app(UnassignUserTask::class)->handle($task->id, $user->id);

        expect($task->users()->count())->toBe(0)
            ->and($user->tasks()->count())->toBe(0);
    });

    it('fire event', function () {
        Event::fake();

        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        app(UnassignUserTask::class)->handle($task->id, $user->id);

        Event::assertDispatched(fn (TaskUnassignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('throw on unassign task not assigned to user', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser()->create();

        $this->assertThrows(fn () => app(UnassignUserTask::class)->handle($task->id, $user->id), CannotUnassignTaskNotPreviouslyAssignedToUserException::class);
    });
});
