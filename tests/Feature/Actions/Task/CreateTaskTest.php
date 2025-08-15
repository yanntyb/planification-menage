<?php

declare(strict_types=1);

use App\Actions\Task\CreateTask;
use App\Events\Task\TaskCreatedEvent;

describe(CreateTask::class, function () {
    it('can create task', function () {
        $task = app(CreateTask::class)->handle([
            'title' => 'tache 1',
            'frequency' => '0000-00-00 00:00:01',
        ]);

        expect($task)
            ->exists()->toBeTrue()
            ->title->toBe('tache 1')
            ->frequency->toString()->toBe('0000-00-00 00:00:01')
            ->current_points->toBeNull();
    });

    it('fire event', function () {
        Event::fake();

        $task = app(CreateTask::class)->handle(['title' => 'tache 1']);

        Event::assertDispatched(fn (TaskCreatedEvent $event) => $event->task->id === $task->id);
    });
});
