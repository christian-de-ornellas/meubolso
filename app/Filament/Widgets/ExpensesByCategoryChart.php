<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ExpensesByCategoryChart extends ChartWidget
{
    protected ?string $heading = 'Despesas por Categoria (Mês Atual)';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $categories = Category::with(['fixedExpenses', 'variableExpenses'])->get();

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($categories as $category) {
            $fixedTotal = $category->fixedExpenses()
                ->where('status', true)
                ->sum('amount');

            $variableTotal = $category->variableExpenses()
                ->whereYear('expense_date', $currentYear)
                ->whereMonth('expense_date', $currentMonth)
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
                    'label' => 'Despesas',
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
