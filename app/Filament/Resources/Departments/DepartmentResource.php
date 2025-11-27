<?php

namespace App\Filament\Resources\Departments;

use App\Filament\Resources\Countries\RelationManagers\EmployeesRelationManager;
use App\Filament\Resources\Departments\Pages\CreateDepartment;
use App\Filament\Resources\Departments\Pages\EditDepartment;
use App\Filament\Resources\Departments\Pages\ListDepartments;
use App\Filament\Resources\Departments\Pages\ViewDepartment;
use App\Filament\Resources\Departments\Schemas\DepartmentForm;
use App\Filament\Resources\Departments\Schemas\DepartmentInfolist;
use App\Filament\Resources\Departments\Tables\DepartmentsTable;
use App\Models\Department;
use BackedEnum;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class DepartmentResource extends Resource
{
    protected static ?string $model = Department::class;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-o-academic-cap";

    protected static string|UnitEnum|null $navigationGroup = "System Management";

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $modelLabel = 'Department';

    protected static ?string $navigationLabel = 'Department';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return DepartmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        // return DepartmentInfolist::configure($schema);
        return $schema
            ->components([

                Section::make('Department Info')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('Employee_count')->state(function (Model $record): int {
                        return $record->employees()->count();
                    }),
                ])->columnSpanFull()->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return DepartmentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // EmployeesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartments::route('/'),
            'create' => CreateDepartment::route('/create'),
            'view' => ViewDepartment::route('/{record}'),
            'edit' => EditDepartment::route('/{record}/edit'),
        ];
    }
}
