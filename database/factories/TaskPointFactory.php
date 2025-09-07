<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\TaskPoint;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskPoint> */
final class TaskPointFactory extends Factory
{
    protected $model = TaskPoint::class;

    public function definition(): array
    {
        return [
            'task_id' => $this->faker->randomNumber(),
            'value' => $this->faker->randomNumber(),
            'is_current' => $this->faker->boolean(),
            'created_at' => CarbonImmutable::now(),
            'updated_at' => CarbonImmutable::now(),
        ];
    }
}
