<?php

namespace App\Filament\Widgets;

use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\Installment;
use App\Models\VariableExpense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyPaymentSummary extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $totalFixedExpenses = FixedExpense::activeInMonth($currentMonth, $currentYear)->sum('amount');
        $totalVariableExpenses = VariableExpense::byMonth($currentMonth, $currentYear)->sum('amount');
        $totalInstallments = Installment::byMonth($currentMonth, $currentYear)
            ->whereHas('installmentExpense')
            ->sum('amount');
        $totalExpenses = $totalFixedExpenses + $totalVariableExpenses + $totalInstallments;

        $payments = ExpensePayment::currentMonth()
            ->active()
            ->with(['fixedExpense', 'variableExpense', 'installment'])
            ->get();
        $totalPaid = $payments->where('paid', true)->sum(function ($payment) {
            if ($payment->installment_id) {
                return $payment->installment?->amount ?? 0;
            }

            return $payment->expense?->amount ?? 0;
        });
        $totalToPay = $totalExpenses - $totalPaid;
        $percentagePaid = $totalExpenses > 0 ? ($totalPaid / $totalExpenses) * 100 : 0;

        $totalPaymentsCount = $payments->count();
        $paidCount = $payments->where('paid', true)->count();
        $unpaidCount = $totalPaymentsCount - $paidCount;

        return [
            Stat::make('Total de Despesas', 'R$ ' . number_format($totalExpenses, 2, ',', '.'))
                ->description($totalPaymentsCount . ' despesas no checklist (fixas + variáveis)')
                ->descriptionIcon('heroicon-o-rectangle-stack')
                ->color('primary'),

            Stat::make('Pago no Mês', 'R$ ' . number_format($totalPaid, 2, ',', '.'))
                ->description($paidCount . ' de ' . $totalPaymentsCount . ' pagamentos realizados')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('A Pagar', 'R$ ' . number_format($totalToPay, 2, ',', '.'))
                ->description($unpaidCount . ' despesas pendentes')
                ->descriptionIcon('heroicon-o-clock')
                ->color($unpaidCount > 0 ? 'warning' : 'success'),

            Stat::make('Percentual Pago', number_format($percentagePaid, 1) . '%')
                ->description($percentagePaid >= 100 ? 'Tudo pago!' : 'Faltam ' . number_format(100 - $percentagePaid, 1) . '%')
                ->descriptionIcon($percentagePaid >= 100 ? 'heroicon-o-check-badge' : 'heroicon-o-arrow-trending-up')
                ->color($percentagePaid >= 100 ? 'success' : ($percentagePaid >= 50 ? 'warning' : 'danger')),
        ];
    }
}
