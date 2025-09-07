<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\RelationManagers;

use App\Actions\User\Task\AssignTask;
use App\Actions\User\Task\CompleteTask;
use App\Filament\Resources\Tasks\Pages\EditTask;
use App\Filament\Resources\TaskUsers\TaskUserResource;
use App\Models\Pivot\TaskUser;
use App\Models\Task;
use App\Models\User;
use App\Services\Task\IsTaskAvailable;
use App\Services\Task\NextAvailability;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method User getOwnerRecord()
 */
final class TasksRelationManager extends RelationManager
{
    protected static string $relationship = 'tasks';

    protected static ?string $relatedResource = TaskUserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Action::make('tasks')
                    ->label('Choisir une tache')
                    ->schema([
                        Select::make('task_id')
                            ->label('Tache')
                            ->options(fn () => Task::query()->assignableTo($this->getOwnerRecord())->pluck('title', 'id')),
                    ])
                    ->action(fn (array $data) => app(AssignTask::class)->handle(Task::findOrFail((int) $data['task_id']), $this->getOwnerRecord())),
            ])
            ->allowDuplicates();
    }
}
