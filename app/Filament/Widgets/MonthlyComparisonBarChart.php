<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class MonthlyComparisonBarChart extends ChartWidget
{
    protected ?string $heading = 'Comparativo Mensal - Receitas vs Despesas (6 Meses)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $months = [];
        $incomesData = [];
        $expensesData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            $months[] = $date->format('M/Y');

            $fixedIncomes = FixedIncome::activeInMonth($month, $year)->sum('amount');
            $variableIncomes = VariableIncome::byMonth($month, $year)->sum('amount');
            $totalIncomes = $fixedIncomes + $variableIncomes;

            $fixedExpenses = FixedExpense::activeInMonth($month, $year)->sum('amount');
            $variableExpenses = VariableExpense::byMonth($month, $year)->sum('amount');
            $totalExpenses = $fixedExpenses + $variableExpenses;

            $incomesData[] = $totalIncomes;
            $expensesData[] = $totalExpenses;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receitas',
                    'data' => $incomesData,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#10b981',
                ],
                [
                    'label' => 'Despesas',
                    'data' => $expensesData,
                    'backgroundColor' => '#ef4444',
                    'borderColor' => '#ef4444',
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "R$ " + value.toLocaleString("pt-BR", {minimumFractionDigits: 2, maximumFractionDigits: 2}); }',
                    ],
                ],
            ],
        ];
    }
}
