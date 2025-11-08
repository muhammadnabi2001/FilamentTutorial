<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\City;
use App\Models\State;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Slider;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Collection;

class EmployeesForm
{
    public static function configure(Schema $schema): Schema
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
                // Section::make('test')
                // ->schema([
                //     MarkdownEditor::make('content')
                // ])->columnSpanFull()
                // Builder::make('content')
                //     ->blocks([
                //         Block::make('heading')
                //             ->schema([
                //                 TextInput::make('content')
                //                     ->label('Heading')
                //                     ->required(),
                //                 Select::make('level')
                //                     ->options([
                //                         'h1' => 'Heading 1',
                //                         'h2' => 'Heading 2',
                //                         'h3' => 'Heading 3',
                //                         'h4' => 'Heading 4',
                //                         'h5' => 'Heading 5',
                //                         'h6' => 'Heading 6',
                //                     ])
                //                     ->required()
                //                     ->native(false),
                //             ])
                //             ->columns(2),
                //         Block::make('paragraph')
                //             ->schema([
                //                 Textarea::make('content')
                //                     ->label('Paragraph')
                //                     ->required(),
                //             ]),
                //         Block::make('image')
                //             ->schema([
                //                 FileUpload::make('url')
                //                     ->label('Image')
                //                     ->image()
                //                     ->required(),
                //                 TextInput::make('alt')
                //                     ->label('Alt text')
                //                     ->required(),
                //             ]),
                //     ])
                // TagsInput::make('percentages')
                //     ->tagSuffix('%')
                //     ->suggestions([
                //         'tailwindcss',
                //         'alpinejs',
                //         'laravel',
                //         'livewire',
                //     ])
                // Textarea::make('description')
                //     ->rows(10)
                //     ->cols(20)
                //     ->autosize()
                //     ->columnSpanFull()
                //     ->disableGrammarly()
                //     ->minLength(2)
                //     ->maxLength(1024)
                //     ->length(100)
                // KeyValue::make('meta')
                //     ->reorderable()
                //     ->addActionLabel('Add property')
                // ToggleButtons::make('status')
                //     ->options([
                //         'draft' => 'Draft',
                //         'scheduled' => 'Scheduled',
                //         'published' => 'Published'
                //     ])
                //     ->icons([
                //         'draft' => Heroicon::OutlinedPencil,
                //         'scheduled' => Heroicon::OutlinedClock,
                //         'published' => Heroicon::OutlinedCheckCircle,
                //     ])
                // Slider::make('slider')
                //     ->range(minValue: 0, maxValue: 100)
                //     ->tooltips()
                // CodeEditor::make('code')
                //     ->language(Language::JavaScript)
            ]);
    }
}
