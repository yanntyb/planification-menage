<?php

use App\Filament\Actions\CompleteAction;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Users\UserResource;
use App\Models\Task;
use function Pest\Livewire\livewire;

beforeAll(function () {
    //$this->actingAs(User::factory()->create());
});

describe(CompleteAction::class, function () {

    it('can complete task', function () {
        $task = Task::factory()->create();

        livewire(CompleteAction::class)->assertOk();



//        livewire(TaskUsersTable::class)
//            ->assertActionVisible(CompleteAction::make('send')->table($task));
//
//        livewire(TaskUsersTable::class)
//            ->assertActionExists(CompleteAction::make('send')->table($task));
    });
});
