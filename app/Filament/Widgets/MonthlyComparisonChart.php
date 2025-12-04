<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class MonthlyComparisonChart extends ChartWidget
{
    protected ?string $heading = 'Comparativo Mensal (Últimos 6 Meses)';

    protected static ?int $sort = 5;

    protected function getData(): array
    {
        $months = [];
        $fixedData = [];
        $variableData = [];

        // Gerar os últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            // Formatar o label do mês
            $months[] = $date->format('M/Y');

            // Calcular total de despesas fixas ativas
            $fixedTotal = FixedExpense::active()->sum('amount');

            // Calcular total de despesas variáveis do mês
            $variableTotal = VariableExpense::byMonth($month, $year)->sum('amount');

            $fixedData[] = $fixedTotal;
            $variableData[] = $variableTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Despesas Fixas',
                    'data' => $fixedData,
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
                [
                    'label' => 'Despesas Variáveis',
                    'data' => $variableData,
                    'borderColor' => '#f59e0b',
                    'backgroundColor' => 'rgba(245, 158, 11, 0.1)',
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
                    'beginAtZero' => true,
                    'ticks' => [
                        'callback' => 'function(value) { return "R$ " + value.toLocaleString("pt-BR", {minimumFractionDigits: 2, maximumFractionDigits: 2}); }',
                    ],
                ],
            ],
        ];
    }
}
