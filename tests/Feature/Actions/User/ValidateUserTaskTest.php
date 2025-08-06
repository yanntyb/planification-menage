<?php

declare(strict_types=1);

use App\Actions\Task\AssignTaskUser;
use App\Actions\User\ValidateUserTask;
use App\Events\TaskAssignedEvent;
use App\Exceptions\Task\CannotValideAlreadyCompletedTaskException;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

describe(ValidateUserTask::class, function () {
    it('can validate task', function () {
        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTaskUser::class)->handle($task->id, $user->id);

        $this->freezeTime(function (Carbon $time) use ($user, $task) {
            app(ValidateUserTask::class)->handle($user->id, $task->id);

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

        app(AssignTaskUser::class)->handle($task->id, $user->id);
        app(ValidateUserTask::class)->handle($user->id, $task->id);

        Event::assertDispatched(fn (TaskAssignedEvent $event) => $event->task->id === $task->id && $event->user->id === $user->id);
    });

    it('should not validate task if user is not the one assigned', function () {
        $task = Task::factory()->withPoints()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        app(AssignTaskUser::class)->handle($task->id, $user1->id);
        app(ValidateUserTask::class)->handle($user2->id, $task->id);

        $userTask = $user1->tasks()->firstWhere('task_id', $task->id);

        /** @var Carbon $completedAt */
        $completedAt = $userTask->pivot->completed_at;

        expect($completedAt)->timestamp->toBeNull();
    });

    it('cannot validate task already completed', function () {
        $task = Task::factory()->withPoints()->create();
        $user = User::factory()->create();

        app(AssignTaskUser::class)->handle($task->id, $user->id);
        app(ValidateUserTask::class)->handle($user->id, $task->id);

        $this->assertThrows(fn () => app(ValidateUserTask::class)->handle($user->id, $task->id), CannotValideAlreadyCompletedTaskException::class);
    });
});
