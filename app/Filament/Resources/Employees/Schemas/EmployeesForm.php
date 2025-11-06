<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EmployeesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    DatePicker::make('date_of_birthday')
                        ->required(),
                    DatePicker::make('date_hired')
                        ->required()
                ])
                ->columnSpanFull()
                ->columns(2),
            ])->columns(3);
    }
}
