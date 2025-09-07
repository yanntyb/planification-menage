<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Actions\Task\Update\UpdateTaskPoint;
use App\Actions\User\Task\AssignTask;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Event;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Event::fake();

        $users = [
            ['name' => 'Utilisateur 1', 'email' => 'user1@google.fr'],
            ['name' => 'Utilisateur 2', 'email' => 'user2@google.fr'],
            ['name' => 'Utilisateur 3', 'email' => 'user3@google.fr'],
            ['name' => 'Utilisateur 4', 'email' => 'user4@google.fr'],
        ];

        $users = User::factory(count($users))
            ->state(new Sequence(...$users))
            ->create();

        $tasks = [
            ['title' => 'Vaisselle'],
            ['title' => 'Faire le menage du bas'],
            ['title' => 'Sortir les poubelles'],
            ['title' => 'Nourrir le chien'],
            ['title' => 'Mettre de l\'essence'],
            ['title' => 'Faire les courses'],
        ];

        $tasks = Task::factory(count($tasks))
            ->state(new Sequence(...$tasks))
            ->hasPoints(1, ['is_current' => true])
            ->create();

        foreach ($tasks as $task) {
            app(UpdateTaskPoint::class)->handle($task, fake()->numberBetween(1, 20));
        }

        collect($tasks)
            ->shuffle()
            ->each(fn (Task $task) => app(AssignTask::class)->handle($task, $users->shuffle()->first()));

    }
}
