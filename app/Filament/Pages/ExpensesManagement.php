<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Page;
use UnitEnum;

class ExpensesManagement extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Despesas';

    protected static ?string $title = 'Gestão de Despesas';

    protected static string|UnitEnum|null $navigationGroup = 'Despesas';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected string $view = 'filament.pages.expenses-management';

    public string $activeTab = 'fixed';

    public function mount(): void
    {
        $this->activeTab = request()->query('tab', 'fixed');
    }
}
