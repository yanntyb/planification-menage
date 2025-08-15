<?php

declare(strict_types=1);

use App\Actions\Task\UpdateTask;
use App\Data\Frequency;
use App\Models\Task;

describe(UpdateTask::class, function () {
    it('can update points', function () {
        $task = Task::factory()->create();

        app(UpdateTask::class)->handle($task, ['points' => 10]);

        expect($task->current_points->value)->toBe(10);
    });

    it('can update frequency', function () {
        $task = Task::factory()->create();

        app(UpdateTask::class)->handle($task, ['frequency' => Frequency::from('0000-00-00 00:00:01')]);

        expect($task->fresh())->frequency->toString()->toBe('0000-00-00 00:00:01');
    });

    it('can update task', function () {
        $task = Task::factory()->create();

        $attr = [
            'points' => 10,
            'frequency' => Frequency::from('0000-00-00 00:00:01'),
            'title' => 'new title',
        ];

        app(UpdateTask::class)->handle($task, $attr);

        expect($task)
            ->title->toBe('new title')
            ->current_points->value->toBe(10)
            ->frequency->toString()->toBe('0000-00-00 00:00:01');
    });
});
