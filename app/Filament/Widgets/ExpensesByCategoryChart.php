<?php

namespace App\Filament\Widgets;

use App\Models\Category;
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

        $start = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $end = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();

        $categories = Category::query()
            ->withSum(
                ['fixedExpenses as fixed_total' => fn ($q) => $q
                    ->where('status', true)
                    ->where('start_date', '<=', $end)
                    ->where(fn ($q2) => $q2->whereNull('end_date')->orWhere('end_date', '>=', $start)),
                ],
                'amount'
            )
            ->withSum(
                ['variableExpenses as variable_total' => fn ($q) => $q
                    ->whereYear('expense_date', $currentYear)
                    ->whereMonth('expense_date', $currentMonth),
                ],
                'amount'
            )
            ->get();

        $data = [];
        $labels = [];
        $colors = [];
        $categoryTotals = [];

        foreach ($categories as $category) {
            $total = ($category->fixed_total ?? 0) + ($category->variable_total ?? 0);

            if ($total > 0) {
                $categoryTotals[] = [
                    'name' => $category->name,
                    'total' => $total,
                    'color' => $category->color ?? '#3b82f6',
                ];
            }
        }

        $grandTotal = array_sum(array_column($categoryTotals, 'total'));
        $this->grandTotal = 'R$ ' . number_format($grandTotal, 2, ',', '.');

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
        if ($this->grandTotal === null) {
            $this->getData();
        }

        return 'Total: ' . $this->grandTotal;
    }
}
