<?php

declare(strict_types=1);

use App\Actions\User\Task\AssignTask;
use App\Actions\User\Task\CompleteTask;
use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\TaskCannotBeCompletedException;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

describe(CompleteTask::class, function () {
    it('can validate task', function () {
        $user = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user)->create();

        $this->freezeTime(function (Carbon $time) use ($user, $task) {
            app(CompleteTask::class)->handle($task, $user);

            $userTask = $user->tasks()->firstWhere('task_id', $task->id);

            /** @var Carbon $completedAt */
            $completedAt = $userTask->pivot->completed_at;

            expect($completedAt)->timestamp->toBe($time->timestamp);
        });
    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTask::class)->handle($task, $user);
        app(CompleteTask::class)->handle($task, $user);

        Event::assertDispatched(fn (TaskAssignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('should not validate task if user is not the one assigned', function () {
        $user1 = User::factory()->create();
        $task = Task::factory()->withPoints()->withUser($user1)->create();
        $user2 = User::factory()->create();

        app(CompleteTask::class)->handle($task, $user2);

        $userTask = $user1->tasks()->firstWhere('task_id', $task->id);

        /** @var Carbon $completedAt */
        $completedAt = $userTask->pivot->completed_at;

        expect($completedAt)->timestamp->toBeNull();
    });

    it('cannot validate task already completed', function () {
        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTask::class)->handle($task, $user);
        app(CompleteTask::class)->handle($task, $user);

        $this->assertThrows(fn () => app(CompleteTask::class)->handle($task, $user), TaskCannotBeCompletedException::class);
    });

    it('throw on trying to complete task not yet available', function () {
        $user = User::factory()->create();
        $task = Task::factory()
            ->completed()
            ->availableAfter('0000-00-00 00:01:00')
            ->create();

        app(AssignTask::class)->handle($task, $user);

        $this->assertThrows(
            fn () => app(CompleteTask::class)->handle($task, $user),
            TaskCannotBeCompletedException::class
        );
    });

    it('can complete task after disabled period', function () {
        $user = User::factory()->create();
        $task = Task::factory()
            ->completed()
            ->availableAfter('0000-00-00 00:01:00')
            ->create();

        app(AssignTask::class)->handle($task, $user);

        $this->travel(1)->minutes();

        $this->assertDoesntThrow(fn () => app(CompleteTask::class)->handle($task, $user));
    });
});
