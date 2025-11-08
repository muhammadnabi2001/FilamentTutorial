<?php

namespace App\Filament\Resources\States;

use App\Filament\Resources\States\Pages\CreateState;
use App\Filament\Resources\States\Pages\EditState;
use App\Filament\Resources\States\Pages\ListStates;
use App\Filament\Resources\States\Schemas\StateForm;
use App\Filament\Resources\States\Tables\StatesTable;
use App\Models\State;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-building-library";

    protected static string|UnitEnum|null $navigationGroup = "System Management";

    protected static ?string $recordTitleAttribute = 'State';

    protected static ?string $navigationLabel = 'State';

    protected static ?string $modelLabel = 'States';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return StateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatesTable::configure($table);
    }
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextEntry::make('country.name')->label('Country Name'),
                // TextEntry::make('name')->label('State Name'),
                Section::make('State info')->schema([
                    TextEntry::make('country.name')->label('Country Name'),
                    TextEntry::make('name')->label('State Name'),
                ])->columnSpanFull()->columns(2)
            ]);
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
            'index' => ListStates::route('/'),
            'create' => CreateState::route('/create'),
            'edit' => EditState::route('/{record}/edit'),
        ];
    }
}
