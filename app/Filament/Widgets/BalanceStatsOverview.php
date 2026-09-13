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

        $fixedIncomes = FixedIncome::activeInMonth($currentMonth, $currentYear)->sum('amount');
        $variableIncomes = VariableIncome::byMonth($currentMonth, $currentYear)->sum('amount');
        $totalIncomes = $fixedIncomes + $variableIncomes;

        $fixedExpenses = FixedExpense::activeInMonth($currentMonth, $currentYear)->sum('amount');
        $variableExpenses = VariableExpense::byMonth($currentMonth, $currentYear)->sum('amount');
        $totalExpenses = $fixedExpenses + $variableExpenses;

        $balance = $totalIncomes - $totalExpenses;

        $savingsRate = $totalIncomes > 0 ? ($balance / $totalIncomes) * 100 : 0;

        return [
            Stat::make('Total Receitas (Mês)', 'R$ ' . number_format($totalIncomes, 2, ',', '.'))
                ->description('Receitas fixas + variáveis')
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success'),

            Stat::make('Total Despesas (Mês)', 'R$ ' . number_format($totalExpenses, 2, ',', '.'))
                ->description('Despesas fixas + variáveis')
                ->descriptionIcon('heroicon-o-arrow-trending-down')
                ->color('danger'),

            Stat::make('Saldo', 'R$ ' . number_format($balance, 2, ',', '.'))
                ->description($balance >= 0 ? 'Positivo' : 'Negativo')
                ->descriptionIcon($balance >= 0 ? 'heroicon-o-arrow-up' : 'heroicon-o-arrow-down')
                ->color($balance >= 0 ? 'success' : 'danger'),

            Stat::make('Taxa de Economia', number_format($savingsRate, 1) . '%')
                ->description('% das receitas economizado')
                ->descriptionIcon('heroicon-o-percent-badge')
                ->color('info'),
        ];
    }
}
