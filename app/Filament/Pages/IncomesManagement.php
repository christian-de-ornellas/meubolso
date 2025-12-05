<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class IncomesManagement extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Receitas';

    protected static ?string $title = 'Gestão de Receitas';

    protected static string|UnitEnum|null $navigationGroup = 'Gestão Financeira';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected string $view = 'filament.pages.incomes-management';

    public string $activeTab = 'fixed';

    public function mount(): void
    {
        $this->activeTab = request()->query('tab', 'fixed');
    }
}
