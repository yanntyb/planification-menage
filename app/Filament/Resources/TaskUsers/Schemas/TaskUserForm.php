<?php

declare(strict_types=1);

namespace App\Filament\Resources\TaskUsers\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class TaskUserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('task_id')
                    ->required()
                    ->numeric(),
                TextInput::make('task_point_id')
                    ->required()
                    ->numeric(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
