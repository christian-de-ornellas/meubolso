<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Tutorial extends Page
{
    protected static ?string $navigationLabel = 'Tutorial';

    protected static ?string $title = 'Tutorial de Uso';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?int $navigationSort = 99;

    protected string $view = 'filament.pages.tutorial';
}
