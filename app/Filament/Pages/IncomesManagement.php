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

    protected static string|UnitEnum|null $navigationGroup = 'Receitas';

    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    protected string $view = 'filament.pages.incomes-management';

    public static function getNavigationItemActiveRoutePattern(): string|array
    {
        return [
            static::getRouteName(),
            'filament.app.resources.fixed-incomes.*',
            'filament.app.resources.variable-incomes.*',
        ];
    }

    public function mount(): void
    {
        $this->redirect(route('filament.app.resources.fixed-incomes.index'));
    }
}
