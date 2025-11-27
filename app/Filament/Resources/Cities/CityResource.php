<?php

namespace App\Filament\Resources\Cities;

use App\Filament\Resources\Cities\Pages\CreateCity;
use App\Filament\Resources\Cities\Pages\EditCity;
use App\Filament\Resources\Cities\Pages\ListCities;
use App\Filament\Resources\Cities\Pages\ViewCity;
use App\Filament\Resources\Cities\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Cities\Schemas\CityForm;
use App\Filament\Resources\Cities\Schemas\CityInfolist;
use App\Filament\Resources\Cities\Tables\CitiesTable;
use App\Models\City;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-building-office-2";

    protected static string|UnitEnum|null $navigationGroup = "System Management";

    // protected static ?string $recordTitleAttribute = 'City';

    protected static ?string $navigationLabel = 'City';

    protected static ?string $modelLabel = 'City';

    protected static ?int $navigationSort = 3;

    public static bool $isScopedToTenant = false;

    public static function form(Schema $schema): Schema
    {
        return CityForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        // return CityInfolist::configure($schema);
        return $schema
            ->components([
                // TextEntry::make('country.name')->label('Country Name'),
                // TextEntry::make('name')->label('State Name'),
                Section::make('City info')->schema([
                    TextEntry::make('state.name')->label('State Name'),
                    TextEntry::make('name')->label('City Name'),
                ])->columnSpanFull()->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return CitiesTable::configure($table);
    }
    
    public static function getRelations(): array
    {
        return [
            EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCities::route('/'),
            'create' => CreateCity::route('/create'),
            // 'view' => ViewCity::route('/{record}'),
            'edit' => EditCity::route('/{record}/edit'),
        ];
    }
}
