<?php

declare(strict_types=1);

use App\Models\Task;
use Illuminate\Testing\Fluent\AssertableJson;

describe('tasks endpoints', function () {
    test('index', function () {
        $task = Task::factory()->create();

        $this->get('/api/tasks')
            ->assertOk()
            ->assertJson(fn (AssertableJson $json) => $json->has('data')
                ->has('data', 1)
                ->has('data.0', fn (AssertableJson $json) => $json->where('id', $task->id)
                    ->where('title', $task->title)
                    ->etc()
                )
            );
    });

    test('store', function () {
        $this->post('/api/tasks', [
            'title' => 'tache 1',
        ])->assertCreated();

        $this->assertDatabaseHas('tasks', [
            'title' => 'tache 1',
        ]);
    });

    test('show', function () {
        $task = Task::factory()->withPoints()->create();

        $this->get('/api/tasks/'.$task->id)
            ->assertOk()
            ->assertExactJson([
                'data' => [
                    'id' => $task->id,
                    'title' => $task->title,
                    'points' => $task->current_points->points,
                ],
            ]);
    });

    test('update', function () {
        $task = Task::factory()->create();

        $this->put('/api/tasks/'.$task->id, [
            'points' => 12,
        ]);

        $this->assertDatabaseHas('task_points', [
            'task_id' => $task->id,
            'points' => 12,
        ]);
    });
});
