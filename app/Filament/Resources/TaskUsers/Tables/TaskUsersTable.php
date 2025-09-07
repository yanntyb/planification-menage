<?php

declare(strict_types=1);

namespace App\Filament\Resources\TaskUsers\Tables;

use App\Filament\Actions\CompleteAction;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

final class TaskUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->sortable(),
                TextColumn::make('points')
                    ->state(fn (TaskUser|Task $record) => Task::find($record->task_id)->current_points->value)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('completed_at')->dateTime()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('A faire')
                    ->default(true)
                    ->queries(
                        true: fn (Builder $query) => $query->whereNull('completed_at'),
                        false: fn (Builder $query) => $query->whereNotNull('email_verified_at'),
                    ),
            ])
            ->recordActions([
                CompleteAction::make('Completer'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultGroup(fn () => Group::make('title')->collapsible())
            ->recordUrl(fn (Task|TaskUser $record) => EditTask::getUrl(['record' => $record]));

    }
}
