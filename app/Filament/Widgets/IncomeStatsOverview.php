<?php

namespace App\Filament\Widgets;

use App\Models\FixedIncome;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class IncomeStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        $fixedIncomesThisMonth = FixedIncome::activeInMonth($currentMonth, $currentYear)
            ->sum('amount');

        $variableIncomesThisMonth = VariableIncome::byMonth($currentMonth, $currentYear)
            ->sum('amount');

        $totalThisMonth = $fixedIncomesThisMonth + $variableIncomesThisMonth;

        $fixedIncomesPrevMonth = FixedIncome::activeInMonth($previousMonth, $previousYear)
            ->sum('amount');

        $variableIncomesPrevMonth = VariableIncome::byMonth($previousMonth, $previousYear)
            ->sum('amount');

        $totalPrevMonth = $fixedIncomesPrevMonth + $variableIncomesPrevMonth;

        $difference = $totalThisMonth - $totalPrevMonth;

        return [
            Stat::make('Receitas Fixas (Mês)', 'R$ ' . number_format($fixedIncomesThisMonth, 2, ',', '.'))
                ->description('Total de receitas fixas ativas no mês')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success'),

            Stat::make('Receitas Variáveis (Mês)', 'R$ ' . number_format($variableIncomesThisMonth, 2, ',', '.'))
                ->description('Total de receitas variáveis deste mês')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary'),

            Stat::make('Total Geral (Mês)', 'R$ ' . number_format($totalThisMonth, 2, ',', '.'))
                ->description(
                    ($difference >= 0 ? '+' : '') .
                    'R$ ' . number_format(abs($difference), 2, ',', '.') .
                    ' vs mês anterior'
                )
                ->descriptionIcon($difference >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($difference >= 0 ? 'success' : 'danger'),
        ];
    }
}
