<?php

declare(strict_types=1);

use App\Models\Task;
use App\Models\TaskPoint;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');

            // Task can be done only after a certain period
            $table->string('available_after')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('task_points', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Task::class);
            $table->integer('points');
            $table->boolean('is_current')->default(false);

            $table->timestamps();
        });

        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Task::class);
            $table->foreignIdFor(TaskPoint::class);

            $table->dateTime('completed_at')->nullable();

            $table->softDeletes();
        });
    }
};
