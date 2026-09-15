<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\Installment;
use App\Models\Subscription;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class CashFlowProjectionChart extends ChartWidget
{
    protected ?string $heading = 'Projeção de Fluxo de Caixa (6 meses)';

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $labels = [];
        $projected = [];
        $realized = [];

        $now = Carbon::now();

        // Médias dos últimos 3 meses para variáveis
        $avgVariableExpense = 0;
        $avgVariableIncome = 0;
        for ($i = 1; $i <= 3; $i++) {
            $pastMonth = $now->copy()->subMonths($i);
            $avgVariableExpense += VariableExpense::byMonth($pastMonth->month, $pastMonth->year)->sum('amount');
            $avgVariableIncome += VariableIncome::byMonth($pastMonth->month, $pastMonth->year)->sum('amount');
        }
        $avgVariableExpense = $avgVariableExpense / 3;
        $avgVariableIncome = $avgVariableIncome / 3;

        $subscriptionMonthly = (float) Subscription::active()->get()->sum(fn ($s) => $s->monthly_equivalent);

        for ($i = 0; $i < 6; $i++) {
            $month = $now->copy()->addMonths($i);
            $labels[] = $month->translatedFormat('M/Y');

            $fixedIncomeMonth = (float) FixedIncome::activeInMonth($month->month, $month->year)->sum('amount');
            $fixedExpenseMonth = (float) FixedExpense::activeInMonth($month->month, $month->year)->sum('amount');

            $installmentsMonth = (float) Installment::byMonth($month->month, $month->year)
                ->whereHas('installmentExpense')
                ->sum('amount');

            $projectedIncome = $fixedIncomeMonth + $avgVariableIncome;
            $projectedExpense = $fixedExpenseMonth + $avgVariableExpense + $subscriptionMonthly + $installmentsMonth;
            $projected[] = round($projectedIncome - $projectedExpense, 2);

            // Realizado: só para meses passados e atual
            if ($month->lte($now->endOfMonth())) {
                $realIncome = (float) FixedIncome::activeInMonth($month->month, $month->year)->sum('amount')
                    + (float) VariableIncome::byMonth($month->month, $month->year)->sum('amount');
                $realExpense = (float) FixedExpense::activeInMonth($month->month, $month->year)->sum('amount')
                    + (float) VariableExpense::byMonth($month->month, $month->year)->sum('amount')
                    + $installmentsMonth;
                $realized[] = round($realIncome - $realExpense, 2);
            } else {
                $realized[] = null;
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Projetado',
                    'data' => $projected,
                    'borderColor' => 'rgb(99, 102, 241)',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'borderDash' => [5, 5],
                ],
                [
                    'label' => 'Realizado',
                    'data' => $realized,
                    'borderColor' => 'rgb(34, 197, 94)',
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
