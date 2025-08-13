<?php

declare(strict_types=1);

use App\Actions\Task\UpdateTaskPoint;
use App\Events\Task\TaskPointUpdatedEvent;
use App\Models\Task;

describe(UpdateTaskPoint::class, function () {
    it('can update current task point', function () {
        $task = Task::factory()->create();

        $action = app(UpdateTaskPoint::class);

        $action->handle($task, 10);

        expect($task->fresh()->current_points->points)->toBe(10);
    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->create();

        $action = app(UpdateTaskPoint::class);

        $action->handle($task, 10);

        Event::assertDispatched(fn (TaskPointUpdatedEvent $event) => $event->taskPoint->task_id === $task->id && $event->taskPoint->points === 10);
    });

    it('should update is_current of latest point', function () {
        $task = Task::factory()->create();

        $action = app(UpdateTaskPoint::class);

        $point1 = $action->handle($task, 10);

        $point2 = $action->handle($task, 20);

        expect($point1->fresh())->is_current->toBeFalse()
            ->and($point2->fresh())->is_current->toBeTrue();

    });
});
