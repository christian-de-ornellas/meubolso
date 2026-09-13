<?php

namespace App\Filament\Widgets;

use App\Models\IncomeCategory;
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

        $start = Carbon::create($currentYear, $currentMonth, 1)->startOfMonth();
        $end = Carbon::create($currentYear, $currentMonth, 1)->endOfMonth();

        $categories = IncomeCategory::query()
            ->withSum(
                ['fixedIncomes as fixed_total' => fn ($q) => $q
                    ->where('status', true)
                    ->where('start_date', '<=', $end)
                    ->where(fn ($q2) => $q2->whereNull('end_date')->orWhere('end_date', '>=', $start)),
                ],
                'amount'
            )
            ->withSum(
                ['variableIncomes as variable_total' => fn ($q) => $q
                    ->whereYear('income_date', $currentYear)
                    ->whereMonth('income_date', $currentMonth),
                ],
                'amount'
            )
            ->get();

        $data = [];
        $labels = [];
        $colors = [];

        foreach ($categories as $category) {
            $total = ($category->fixed_total ?? 0) + ($category->variable_total ?? 0);

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
