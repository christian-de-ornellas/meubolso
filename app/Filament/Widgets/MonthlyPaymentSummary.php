<?php

namespace App\Filament\Widgets;

use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyPaymentSummary extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Total de despesas fixas ativas
        $totalExpenses = FixedExpense::active()->sum('amount');

        // Pagamentos do mês atual
        $payments = ExpensePayment::currentMonth()->get();
        $totalPaid = $payments->where('paid', true)->sum(fn ($payment) => $payment->fixedExpense->amount);
        $totalToPay = $totalExpenses - $totalPaid;
        $percentagePaid = $totalExpenses > 0 ? ($totalPaid / $totalExpenses) * 100 : 0;

        // Conta quantas despesas foram pagas vs total
        $totalPaymentsCount = $payments->count();
        $paidCount = $payments->where('paid', true)->count();
        $unpaidCount = $totalPaymentsCount - $paidCount;

        return [
            Stat::make('Total de Despesas Fixas', 'R$ ' . number_format($totalExpenses, 2, ',', '.'))
                ->description($totalPaymentsCount . ' despesas no checklist')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('primary'),

            Stat::make('Pago no Mês', 'R$ ' . number_format($totalPaid, 2, ',', '.'))
                ->description($paidCount . ' de ' . $totalPaymentsCount . ' pagamentos realizados')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success')
                ->chart([$paidCount, $unpaidCount]),

            Stat::make('A Pagar', 'R$ ' . number_format($totalToPay, 2, ',', '.'))
                ->description($unpaidCount . ' despesas pendentes')
                ->descriptionIcon('heroicon-o-clock')
                ->color($unpaidCount > 0 ? 'warning' : 'success'),

            Stat::make('Percentual Pago', number_format($percentagePaid, 1) . '%')
                ->description($percentagePaid >= 100 ? 'Tudo pago!' : 'Faltam ' . number_format(100 - $percentagePaid, 1) . '%')
                ->descriptionIcon($percentagePaid >= 100 ? 'heroicon-o-check-badge' : 'heroicon-o-arrow-trending-up')
                ->color($percentagePaid >= 100 ? 'success' : ($percentagePaid >= 50 ? 'warning' : 'danger'))
                ->chart([$percentagePaid, 100 - $percentagePaid]),
        ];
    }
}
