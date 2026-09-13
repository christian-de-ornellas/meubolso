<?php

namespace App\Filament\Widgets;

use App\Models\Subscription;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SubscriptionsCostOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 5;

    protected function getStats(): array
    {
        $activeSubscriptions = Subscription::active()->get();
        $monthlyCost = $activeSubscriptions->sum(fn ($sub) => $sub->monthly_equivalent);
        $yearlyCost = $monthlyCost * 12;
        $activeCount = $activeSubscriptions->count();

        return [
            Stat::make('Custo Mensal', 'R$ ' . number_format($monthlyCost, 2, ',', '.'))
                ->description('Total de assinaturas ativas')
                ->color('warning')
                ->icon('heroicon-o-arrow-path'),

            Stat::make('Custo Anual', 'R$ ' . number_format($yearlyCost, 2, ',', '.'))
                ->description('Projeção anual')
                ->color('danger')
                ->icon('heroicon-o-calendar'),

            Stat::make('Assinaturas Ativas', $activeCount)
                ->description('Quantidade')
                ->color('info')
                ->icon('heroicon-o-arrow-path'),
        ];
    }
}
