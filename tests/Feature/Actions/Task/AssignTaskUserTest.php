<?php

declare(strict_types=1);

use App\Actions\Task\AssignTaskUser;
use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\CannotAssignTaskWithoutPointException;
use App\Models\Task;
use App\Models\User;

describe(AssignTaskUser::class, function () {
    it('assign task to user', function () {
        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTaskUser::class)->handle($task->id, $user->id);

        expect($task->users()->first()->id)->toBe($user->id)
            ->and($user->tasks()->first()->id)->toBe($task->id);
    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTaskUser::class)->handle($task->id, $user->id);

        Event::assertDispatched(fn (TaskAssignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('throw on assign task without point', function () {
        $task = Task::factory()->create();
        $user = User::factory()->create();

        $this->assertThrows(fn () => app(AssignTaskUser::class)->handle($task->id, $user->id), CannotAssignTaskWithoutPointException::class);
    });
});
