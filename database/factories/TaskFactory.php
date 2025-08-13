<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Actions\Task\UpdateTaskPoint;
use App\Actions\User\AssignUserTask;
use App\Actions\User\CompleteUserTask;
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

    public function availableAfter(string $time): self
    {
        return $this->state(fn (array $attributes) => [
            'available_after' => $time,
        ]);
    }

    public function withPoints(?int $points = null): self
    {
        $points ??= fake()->numberBetween(1, 100);

        return $this->afterCreating(fn (Task $task) => app(UpdateTaskPoint::class)->handle($task, $points));
    }

    public function withUser(?User $user = null): self
    {
        $user ??= User::factory()->create();

        return $this->afterCreating(fn (Task $task) => app(AssignUserTask::class)->handle($task, $user));
    }

    public function completed(?User $user = null, int $points = 100)
    {
        $user ??= User::factory()->create();

        return $this
            ->withPoints($points)
            ->withUser($user)
            ->afterCreating(fn (Task $task) => app(CompleteUserTask::class)->handle($task, $user));
    }
}
