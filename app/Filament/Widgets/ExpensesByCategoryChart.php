<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ExpensesByCategoryChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $grandTotal = null;

    protected function getData(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $categories = Category::with(['fixedExpenses', 'variableExpenses'])->get();

        $data = [];
        $labels = [];
        $colors = [];
        $categoryTotals = [];

        // Primeiro, calcular todos os totais
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
                $categoryTotals[] = [
                    'name' => $category->name,
                    'total' => $total,
                    'color' => $category->color ?? '#3b82f6',
                ];
            }
        }

        // Calcular o total geral
        $grandTotal = array_sum(array_column($categoryTotals, 'total'));
        $this->grandTotal = 'R$ ' . number_format($grandTotal, 2, ',', '.');

        // Gerar labels com percentuais
        foreach ($categoryTotals as $cat) {
            $percentage = $grandTotal > 0 ? ($cat['total'] / $grandTotal) * 100 : 0;
            $labels[] = $cat['name'] . ' (' . number_format($percentage, 1) . '%)';
            $data[] = $cat['total'];
            $colors[] = $cat['color'];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Valor',
                    'data' => $data,
                    'backgroundColor' => $colors,
                    'borderColor' => $colors,
                    'borderWidth' => 2,
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
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'maintainAspectRatio' => true,
            'responsive' => true,
        ];
    }

    public function getHeading(): ?string
    {
        return 'Despesas por Categoria (Mês Atual)';
    }

    public function getDescription(): ?string
    {
        // Garantir que getData() foi chamado
        if ($this->grandTotal === null) {
            $this->getData();
        }

        return 'Total: ' . $this->grandTotal;
    }
}
