<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class BalanceStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Total de Receitas do Mês
        $fixedIncomes = FixedIncome::active()->sum('amount');
        $variableIncomes = VariableIncome::byMonth($currentMonth, $currentYear)->sum('amount');
        $totalIncomes = $fixedIncomes + $variableIncomes;

        // Total de Despesas do Mês
        $fixedExpenses = FixedExpense::active()->sum('amount');
        $variableExpenses = VariableExpense::byMonth($currentMonth, $currentYear)->sum('amount');
        $totalExpenses = $fixedExpenses + $variableExpenses;

        // Saldo
        $balance = $totalIncomes - $totalExpenses;

        // Taxa de Economia
        $savingsRate = $totalIncomes > 0 ? ($balance / $totalIncomes) * 100 : 0;

        return [
            Stat::make('Total Receitas (Mês)', 'R$ ' . number_format($totalIncomes, 2, ',', '.'))
                ->description('Receitas fixas + variáveis')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart([5, 6, 7, 8, 9, 10, 11, 12]),

            Stat::make('Total Despesas (Mês)', 'R$ ' . number_format($totalExpenses, 2, ',', '.'))
                ->description('Despesas fixas + variáveis')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger')
                ->chart([12, 11, 10, 9, 8, 7, 6, 5]),

            Stat::make('Saldo', 'R$ ' . number_format($balance, 2, ',', '.'))
                ->description($balance >= 0 ? 'Positivo' : 'Negativo')
                ->descriptionIcon($balance >= 0 ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down')
                ->color($balance >= 0 ? 'success' : 'danger')
                ->chart($balance >= 0 ? [3, 4, 5, 6, 7, 8, 9, 10] : [10, 9, 8, 7, 6, 5, 4, 3]),

            Stat::make('Taxa de Economia', number_format($savingsRate, 1) . '%')
                ->description('% das receitas economizado')
                ->descriptionIcon('heroicon-o-percent-badge')
                ->color('info')
                ->chart([4, 5, 6, 5, 7, 6, 8, 7]),
        ];
    }
}
