<?php

namespace App\Filament\Widgets;

use App\Models\IncomeCategory;
use App\Models\FixedIncome;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class IncomesByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Receitas por Categoria (Mês Atual)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $categories = IncomeCategory::with(['fixedIncomes', 'variableIncomes'])->get();

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($categories as $category) {
            $fixedTotal = $category->fixedIncomes()
                ->where('status', true)
                ->sum('amount');

            $variableTotal = $category->variableIncomes()
                ->whereYear('income_date', $currentYear)
                ->whereMonth('income_date', $currentMonth)
                ->sum('amount');

            $total = $fixedTotal + $variableTotal;

            if ($total > 0) {
                $labels[] = $category->name;
                $data[] = $total;
                $colors[] = $category->color ?? '#3b82f6';
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Receitas',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
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
        ];
    }
}
