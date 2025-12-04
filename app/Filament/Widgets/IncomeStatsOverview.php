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

        // Totais do mês atual
        $fixedIncomesThisMonth = FixedIncome::active()
            ->sum('amount');

        $variableIncomesThisMonth = VariableIncome::byMonth($currentMonth, $currentYear)
            ->sum('amount');

        $totalThisMonth = $fixedIncomesThisMonth + $variableIncomesThisMonth;

        // Totais do mês anterior
        $fixedIncomesPrevMonth = FixedIncome::active()
            ->sum('amount');

        $variableIncomesPrevMonth = VariableIncome::byMonth($previousMonth, $previousYear)
            ->sum('amount');

        $totalPrevMonth = $fixedIncomesPrevMonth + $variableIncomesPrevMonth;

        // Cálculo da diferença
        $difference = $totalThisMonth - $totalPrevMonth;
        $percentageChange = $totalPrevMonth > 0
            ? (($difference / $totalPrevMonth) * 100)
            : 0;

        return [
            Stat::make('Receitas Fixas Ativas', 'R$ ' . number_format($fixedIncomesThisMonth, 2, ',', '.'))
                ->description('Total de receitas fixas ativas')
                ->descriptionIcon('heroicon-o-currency-dollar')
                ->color('success')
                ->chart([5, 3, 7, 4, 8, 6, 9, 7]),

            Stat::make('Receitas Variáveis (Mês)', 'R$ ' . number_format($variableIncomesThisMonth, 2, ',', '.'))
                ->description('Total de receitas variáveis deste mês')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('primary')
                ->chart([3, 5, 7, 4, 6, 8, 5, 9]),

            Stat::make('Total Geral (Mês)', 'R$ ' . number_format($totalThisMonth, 2, ',', '.'))
                ->description(
                    ($difference >= 0 ? '+' : '') .
                    'R$ ' . number_format(abs($difference), 2, ',', '.') .
                    ' vs mês anterior'
                )
                ->descriptionIcon($difference >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($difference >= 0 ? 'success' : 'danger')
                ->chart([4, 6, 5, 8, 7, 9, 8, 10]),
        ];
    }
}
