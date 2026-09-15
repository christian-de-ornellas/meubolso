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

    public static function getNavigationItemActiveRoutePattern(): string|array
    {
        return [
            static::getRouteName(),
            'filament.app.resources.fixed-expenses.*',
            'filament.app.resources.variable-expenses.*',
        ];
    }

    public function mount(): void
    {
        $this->redirect(route('filament.app.resources.fixed-expenses.index'));
    }
}
