<?php

declare(strict_types=1);

namespace App\Filament\Resources\TaskUsers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

final class TaskUserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('task_id')
                    ->numeric(),
                TextEntry::make('task_point_id')
                    ->numeric(),
                TextEntry::make('completed_at')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime(),
            ]);
    }
}
