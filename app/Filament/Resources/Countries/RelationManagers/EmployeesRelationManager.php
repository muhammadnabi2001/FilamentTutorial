<?php

namespace App\Filament\Resources\Countries\RelationManagers;

use App\Models\City;
use App\Models\State;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Collection;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Relationships')
                    ->schema([
                        Select::make('country_id')
                            ->relationship(name: 'country', titleAttribute: 'name')
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set) {
                                $set('state_id', null);
                                $set('city_id', null);
                            })
                            ->required(),
                        Select::make('state_id')
                            ->options(fn(Get $get): Collection => State::query()
                                ->where('country_id', $get('country_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn(Set $set) => $set('city_id', null))
                            ->required(),
                        Select::make('city_id')
                            ->options(fn(Get $get): Collection => City::query()
                                ->where('state_id', $get('state_id'))
                                ->pluck('name', 'id'))
                            ->searchable()
                            ->live()
                            ->preload()
                            ->required(),
                        Select::make('department_id')
                            ->relationship(name: 'department', titleAttribute: 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                    ])
                    ->columnSpanFull()
                    ->columns(2),
                Section::make('User Name')
                    ->description('Put the user name details in')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('middle_name')
                            ->required()
                            ->maxLength(255),

                    ])
                    ->columnSpanFull()
                    ->columns(3),
                Section::make("User address")->schema([
                    TextInput::make('address')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('zip_code')
                        ->required()
                        ->maxLength(255),
                ])
                    ->columnSpanFull()
                    ->columns(2),
                Section::make("Dates")->schema([
                    DatePicker::make('date_of_birth')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required(),
                    DatePicker::make('date_hired')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->required()
                ])
                    ->columnSpanFull()
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                TextColumn::make('first_name'),
                TextColumn::make('last_name'),
                TextColumn::make('middle_name')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('address')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('zip_code'),
                TextColumn::make('date_of_birth')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_hired')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
