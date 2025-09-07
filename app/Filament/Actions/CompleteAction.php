<?php

namespace App\Filament\Actions;

use App\Actions\User\Task\CompleteTask;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Services\Task\IsTaskAvailable;
use App\Services\Task\NextAvailability;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class CompleteAction extends Action
{
    public function configure(): static
    {
        return $this
            ->disabled(
                fn(Task|TaskUser $record) => $record->completed_at !== null || !app(IsTaskAvailable::class)->check($record)
            )
            ->label(
                function (TaskUser|Task $record) {
                    if ($record->completed_at !== null) {
                        return '';
                    }

                    if (! app(IsTaskAvailable::class)->check($record)) {
                        return 'Bloquée jusqu\'au '.app(NextAvailability::class)->get($record)->toDateTimeString();
                    }

                    return 'Completer';
                })
            ->icon(fn (TaskUser|Task $record) => $record->completed_at !== null ? Heroicon::Check : null)
            ->color(function (TaskUser|Task $record) {
                $available = app(IsTaskAvailable::class)->check($record);

                return match (true) {
                    $record->completed_at !== null => '',
                    ($record->completed_at === null && $available) => 'success',
                    ! $available => 'warning',
                    default => 'gray',
                };
            })
            ->action(fn (TaskUser|Task $record) => app(CompleteTask::class)->handle($record, $record->user));
    }
}
