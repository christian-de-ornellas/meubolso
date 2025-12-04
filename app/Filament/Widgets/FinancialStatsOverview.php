<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FinancialStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $previousMonth = Carbon::now()->subMonth()->month;
        $previousYear = Carbon::now()->subMonth()->year;

        // Totais do mês atual
        $fixedExpensesThisMonth = FixedExpense::active()
            ->sum('amount');

        $variableExpensesThisMonth = VariableExpense::byMonth($currentMonth, $currentYear)
            ->sum('amount');

        $totalThisMonth = $fixedExpensesThisMonth + $variableExpensesThisMonth;

        // Totais do mês anterior
        $fixedExpensesPrevMonth = FixedExpense::active()
            ->sum('amount');

        $variableExpensesPrevMonth = VariableExpense::byMonth($previousMonth, $previousYear)
            ->sum('amount');

        $totalPrevMonth = $fixedExpensesPrevMonth + $variableExpensesPrevMonth;

        // Cálculo da diferença
        $difference = $totalThisMonth - $totalPrevMonth;
        $percentageChange = $totalPrevMonth > 0
            ? (($difference / $totalPrevMonth) * 100)
            : 0;

        return [
            Stat::make('Despesas Fixas Ativas', 'R$ ' . number_format($fixedExpensesThisMonth, 2, ',', '.'))
                ->description('Total de despesas fixas ativas')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

            Stat::make('Despesas Variáveis (Mês)', 'R$ ' . number_format($variableExpensesThisMonth, 2, ',', '.'))
                ->description('Total de despesas variáveis deste mês')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('warning')
                ->chart([3, 5, 3, 7, 4, 5, 6, 7]),

            Stat::make('Total Geral (Mês)', 'R$ ' . number_format($totalThisMonth, 2, ',', '.'))
                ->description(
                    ($difference >= 0 ? '+' : '') .
                    'R$ ' . number_format(abs($difference), 2, ',', '.') .
                    ' vs mês anterior'
                )
                ->descriptionIcon($difference >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($difference >= 0 ? 'danger' : 'success')
                ->chart([3, 4, 5, 6, 5, 4, 7, 6]),
        ];
    }
}
