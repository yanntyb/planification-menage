<?php

declare(strict_types=1);

use App\Http\Resources\TaskResource;
use App\Models\Task;

describe('/api/tasks', function () {
    describe('/{id}', function () {
        test('put', function () {
            $task = Task::factory()->create();

            $this->put('/api/tasks/'.$task->id, [
                'points' => 12,
            ]);

            $this->assertDatabaseHas('task_points', [
                'task_id' => $task->id,
                'value' => 12,
            ]);
        });

        test('get', function () {
            $task = Task::factory()->withPoints()->create();

            $this->get('/api/tasks/'.$task->id)
                ->assertOk()
                ->assertExactJson(TaskResource::make($task)->resolve());
        });

        test('delete', function () {
            $task = Task::factory()->create();

            $this->delete('/api/tasks/'.$task->id)->assertNoContent();

            $this->assertDatabaseMissing('tasks', [
                'id' => $task->id,
                'deleted_at' => null,
            ]);
        });
    });

    describe('/', function () {
        describe('post', function () {
            test('can post a task', function () {
                $this->post('/api/tasks', [
                    'title' => 'tache 1',
                    'frequency' => '0000-00-00 00:00:01',
                ])->assertCreated();

                $this->assertDatabaseHas('tasks', [
                    'title' => 'tache 1',
                    'frequency' => '0000-00-00 00:00:01',
                ]);
            });

            test('cannot post a task with wrong frequency format', function () {
                $this->post('/api/tasks', [
                    'title' => 'tache 1',
                    'frequency' => '00000000000001',
                ])->assertInvalid(['frequency']);
            });
        });

        test('get', function () {
            $task = Task::factory()->create();

            $this->get('/api/tasks')
                ->assertOk()
                ->assertJson([
                    TaskResource::make($task)->resolve(),
                ]);
        });
    });
});
