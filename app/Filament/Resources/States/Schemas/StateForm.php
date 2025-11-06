<?php

namespace App\Filament\Resources\States\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('country_id')
                    ->relationship(name: 'country', titleAttribute: 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    // ->multiple()
                    ,
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
