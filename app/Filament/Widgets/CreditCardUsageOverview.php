<?php

namespace App\Filament\Widgets;

use App\Models\CreditCard;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CreditCardUsageOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $cards = CreditCard::active()->get();

        if ($cards->isEmpty()) {
            return [
                Stat::make('Cartões de Crédito', 'Nenhum')
                    ->description('Nenhum cartão cadastrado')
                    ->color('gray')
                    ->icon('heroicon-o-credit-card'),
            ];
        }

        $cardIds = $cards->pluck('id');

        $variableByCard = VariableExpense::query()
            ->whereIn('credit_card_id', $cardIds)
            ->whereMonth('expense_date', now()->month)
            ->whereYear('expense_date', now()->year)
            ->groupBy('credit_card_id')
            ->selectRaw('credit_card_id, sum(amount) as total')
            ->pluck('total', 'credit_card_id');

        $fixedByCard = FixedExpense::query()
            ->whereIn('credit_card_id', $cardIds)
            ->active()
            ->groupBy('credit_card_id')
            ->selectRaw('credit_card_id, sum(amount) as total')
            ->pluck('total', 'credit_card_id');

        $stats = [];

        foreach ($cards as $card) {
            $used = (float) ($variableByCard[$card->id] ?? 0) + (float) ($fixedByCard[$card->id] ?? 0);
            $limit = (float) $card->credit_limit;
            $percentage = $limit > 0 ? round(($used / $limit) * 100, 1) : 0;
            $color = $percentage > 90 ? 'danger' : ($percentage > 75 ? 'warning' : 'success');

            $stats[] = Stat::make($card->name, 'R$ ' . number_format($used, 2, ',', '.'))
                ->description($percentage . '% do limite de R$ ' . number_format($limit, 2, ',', '.'))
                ->color($color)
                ->icon('heroicon-o-credit-card');
        }

        return $stats;
    }
}
