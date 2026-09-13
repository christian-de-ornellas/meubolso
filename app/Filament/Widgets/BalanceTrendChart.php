<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class BalanceTrendChart extends ChartWidget
{
    protected ?string $heading = 'Evolução do Saldo (Últimos 6 Meses)';

    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $months = [];
        $balanceData = [];

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

            $balance = $totalIncomes - $totalExpenses;
            $balanceData[] = $balance;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Saldo',
                    'data' => $balanceData,
                    'borderColor' => '#8b5cf6',
                    'backgroundColor' => 'rgba(139, 92, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
                    'beginAtZero' => false,
                    'ticks' => [
                        'callback' => 'function(value) { return "R$ " + value.toLocaleString("pt-BR", {minimumFractionDigits: 2, maximumFractionDigits: 2}); }',
                    ],
                ],
            ],
        ];
    }
}
