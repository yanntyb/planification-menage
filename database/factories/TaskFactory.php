<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Task\UpdateTaskPoint;
use App\Actions\User\AssignUserTask;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/** @extends Factory<Task> */
final class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    public function withPoints(?int $points = null): self
    {
        return $this->afterCreating(function (Task $task) use ($points) {
            app(UpdateTaskPoint::class)->handle($task->id, $points ?? fake()->numberBetween(1, 100));
        });
    }

    public function withUser(?User $user = null): self
    {
        return $this->afterCreating(function (Task $task) use ($user) {
            app(AssignUserTask::class)->handle($task->id, ($user ?? User::factory()->create())->id);
        });
    }
}
