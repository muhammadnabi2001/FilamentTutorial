<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class CountryView extends Page
{
    protected string $view = 'filament.pages.country-view';
    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }
}
