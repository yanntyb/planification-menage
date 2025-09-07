<?php

declare(strict_types=1);

namespace App\Filament\Resources\Tasks\Schemas;

use App\Filament\Forms\Components\Field\FrequencyInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

final class TaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                FrequencyInput::make('frequency'),
            ]);
    }
}
