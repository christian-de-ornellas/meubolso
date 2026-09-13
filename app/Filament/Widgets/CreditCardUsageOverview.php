<?php

namespace App\Filament\Widgets;

use App\Models\CreditCard;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CreditCardUsageOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $cards = CreditCard::active()->get();
        $stats = [];

        foreach ($cards as $card) {
            $used = $card->variableExpenses()
                ->whereMonth('expense_date', now()->month)
                ->whereYear('expense_date', now()->year)
                ->sum('amount')
                + $card->fixedExpenses()
                ->active()
                ->sum('amount');

            $limit = (float) $card->credit_limit;
            $percentage = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;
            $color = $percentage > 90 ? 'danger' : ($percentage > 75 ? 'warning' : 'success');

            $stats[] = Stat::make($card->name, 'R$ ' . number_format($used, 2, ',', '.'))
                ->description($percentage . '% do limite de R$ ' . number_format($limit, 2, ',', '.'))
                ->color($color)
                ->icon('heroicon-o-credit-card');
        }

        if (empty($stats)) {
            $stats[] = Stat::make('Cartões de Crédito', 'Nenhum')
                ->description('Nenhum cartão cadastrado')
                ->color('gray')
                ->icon('heroicon-o-credit-card');
        }

        return $stats;
    }
}
