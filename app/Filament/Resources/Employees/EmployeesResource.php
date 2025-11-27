<?php

namespace App\Filament\Resources\Employees;

use App\Filament\Resources\Employees\Pages\CreateEmployees;
use App\Filament\Resources\Employees\Pages\EditEmployees;
use App\Filament\Resources\Employees\Pages\ListEmployees;
use App\Filament\Resources\Employees\Pages\ViewEmployees;
use App\Filament\Resources\Employees\Schemas\EmployeesForm;
use App\Filament\Resources\Employees\Schemas\EmployeesInfolist;
use App\Filament\Resources\Employees\Tables\EmployeesTable;
use App\Models\Employee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class EmployeesResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-user-group";

    protected static string|UnitEnum|null $navigationGroup = "Employee Management";

    protected static ?string $recordTitleAttribute = 'FirstName';


    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->first_name;
        //the result's title will be first_name
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'middle_name', 'country.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Country' => $record->country->name,
            // 'Last name' => $record->last_name,
        ];
    }
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['country']);
    }
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'success';
    }
    public static function form(Schema $schema): Schema
    {
        return EmployeesForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return EmployeesInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EmployeesTable::configure($table);
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
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployees::route('/create'),
            // 'view' => ViewEmployees::route('/{record}'),
            'edit' => EditEmployees::route('/{record}/edit'),
        ];
    }
}
