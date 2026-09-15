<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\Installment;
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

        $fixedExpensesThisMonth = FixedExpense::activeInMonth($currentMonth, $currentYear)
            ->sum('amount');

        $variableExpensesThisMonth = VariableExpense::byMonth($currentMonth, $currentYear)
            ->sum('amount');

        $installmentsThisMonth = Installment::byMonth($currentMonth, $currentYear)
            ->whereHas('installmentExpense')
            ->sum('amount');

        $totalThisMonth = $fixedExpensesThisMonth + $variableExpensesThisMonth + $installmentsThisMonth;

        $fixedExpensesPrevMonth = FixedExpense::activeInMonth($previousMonth, $previousYear)
            ->sum('amount');

        $variableExpensesPrevMonth = VariableExpense::byMonth($previousMonth, $previousYear)
            ->sum('amount');

        $installmentsPrevMonth = Installment::byMonth($previousMonth, $previousYear)
            ->whereHas('installmentExpense')
            ->sum('amount');

        $totalPrevMonth = $fixedExpensesPrevMonth + $variableExpensesPrevMonth + $installmentsPrevMonth;

        $difference = $totalThisMonth - $totalPrevMonth;

        return [
            Stat::make('Despesas Fixas (Mês)', 'R$ ' . number_format($fixedExpensesThisMonth, 2, ',', '.'))
                ->description('Total de despesas fixas ativas no mês')
                ->descriptionIcon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make('Despesas Variáveis (Mês)', 'R$ ' . number_format($variableExpensesThisMonth, 2, ',', '.'))
                ->description('Total de despesas variáveis deste mês')
                ->descriptionIcon('heroicon-o-banknotes')
                ->color('warning'),

            Stat::make('Total Geral (Mês)', 'R$ ' . number_format($totalThisMonth, 2, ',', '.'))
                ->description(
                    ($difference >= 0 ? '+' : '') .
                    'R$ ' . number_format(abs($difference), 2, ',', '.') .
                    ' vs mês anterior'
                )
                ->descriptionIcon($difference >= 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down')
                ->color($difference >= 0 ? 'danger' : 'success'),
        ];
    }
}
