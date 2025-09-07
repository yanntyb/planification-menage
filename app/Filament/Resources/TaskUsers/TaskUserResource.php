<?php

declare(strict_types=1);

namespace App\Filament\Resources\TaskUsers;

use App\Filament\Resources\TaskUsers\Schemas\TaskUserForm;
use App\Filament\Resources\TaskUsers\Schemas\TaskUserInfolist;
use App\Filament\Resources\TaskUsers\Tables\TaskUsersTable;
use App\Models\Pivot\TaskUser;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

final class TaskUserResource extends Resource
{
    protected static ?string $model = TaskUser::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TaskUserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TaskUserInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TaskUsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
        ];
    }
}
