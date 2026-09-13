<?php

namespace App\Filament\Widgets;

use App\Models\Account;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AccountBalancesOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $accounts = Account::active()->get();
        $totalBalance = $accounts->sum('current_balance');
        $activeCount = $accounts->count();

        return [
            Stat::make('Saldo Total', 'R$ ' . number_format($totalBalance, 2, ',', '.'))
                ->description('Soma de todas as contas ativas')
                ->color('success')
                ->icon('heroicon-o-building-library'),

            Stat::make('Contas Ativas', $activeCount)
                ->description('Quantidade de contas ativas')
                ->color('info')
                ->icon('heroicon-o-wallet'),
        ];
    }
}
