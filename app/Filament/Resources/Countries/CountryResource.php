<?php

namespace App\Filament\Resources\Countries;

use App\Filament\Resources\Countries\Pages\CreateCountry;
use App\Filament\Resources\Countries\Pages\EditCountry;
use App\Filament\Resources\Countries\Pages\ListCountries;
use App\Filament\Resources\Countries\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Countries\RelationManagers\StatesRelationManager;
use App\Filament\Resources\Countries\Schemas\CountryForm;
use App\Filament\Resources\Countries\Tables\CountriesTable;
use App\Models\Country;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Ramsey\Uuid\Type\Integer;
use UnitEnum;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-flag";

    protected static string | UnitEnum | null $navigationGroup = 'System Management';

    protected static ?string $recordTitleAttribute = 'Country';

    protected static ?string $navigationLabel = 'Countries';

    protected static ?string $modelLabel = 'Employees Country';

    protected static ?string $slug = 'employees-country';

    protected static ?int $navigationSort = 1;


    public static function form(Schema $schema): Schema
    {
        return CountryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CountriesTable::configure($table);
    }
    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Country info')->schema([
                    TextEntry::make('name')->label('Name'),
                    TextEntry::make('code')->label('Country Code'),
                    TextEntry::make('phonecode')->label('Phone Code'),
                ])->columnSpanFull()->columns(3),

            ]);
    }
    public static function getRelations(): array
    {
        return [
            StatesRelationManager::class,
            EmployeesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCountries::route('/'),
            'create' => CreateCountry::route('/create'),
            'view' => Pages\ViewCountry::route('/{record}'),
            'edit' => EditCountry::route('/{record}/edit'),
        ];
    }
}
