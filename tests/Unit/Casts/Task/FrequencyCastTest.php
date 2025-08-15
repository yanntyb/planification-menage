<?php

declare(strict_types=1);

use App\Casts\Task\FrequencyCast;
use App\Data\Frequency;
use App\Models\Task;

describe(FrequencyCast::class, function () {
    it('can transform db value into object', function () {
        $task = Task::factory()->create();

        $frequency = app(FrequencyCast::class)->get($task, 'frequency', '0000-00-00 00:10:00', []);

        expect($frequency)
            ->toBeInstanceOf(Frequency::class)
            ->minutes->toBe(10);
    });

    it('can transform object into db value', function () {
        $task = Task::factory()->create();

        $frequency = app(FrequencyCast::class)->set($task, 'frequency', Frequency::from('0000-00-00 00:10:00'), []);

        expect($frequency)->toBe('0000-00-00 00:10:00');
    });
});
