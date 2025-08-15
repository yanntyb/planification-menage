<?php

declare(strict_types=1);

use App\Actions\Task\Update\UpdateTaskFrequency;
use App\Data\Frequency;
use App\Events\Task\TaskFrequencyUpdated;
use App\Exceptions\FrequencyInstantiationException;
use App\Models\Task;

describe(UpdateTaskFrequency::class, function () {
    it('can update task frequency using string', function () {
        $task = Task::factory()->create();

        app(UpdateTaskFrequency::class)->handle($task, '0000-00-00 00:00:01');

        expect($task->fresh())->frequency->toString()->toBe('0000-00-00 00:00:01');
    });

    it('can update task frequency using frequency object', function () {
        $task = Task::factory()->create();

        $frequency = Frequency::from('0000-00-00 00:00:01');

        app(UpdateTaskFrequency::class)->handle($task, $frequency);

        expect($task->fresh())->frequency->toString()->toBe($frequency->toString());

    });

    it('fire event', function () {
        Event::fake();

        $task = Task::factory()->create();

        app(UpdateTaskFrequency::class)->handle($task, '0000-00-00 00:00:01');

        Event::assertDispatched(fn (TaskFrequencyUpdated $event) => $event->task->id === $task->id);
    });

    test('throw on wrong format', function () {
        $task = Task::factory()->create();

        $this->assertThrows(fn () => app(UpdateTaskFrequency::class)->handle($task, '0000-00-00'), FrequencyInstantiationException::class);
    });
});
