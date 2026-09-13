<?php

namespace App\Console\Commands;

use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\VariableExpense;
use Illuminate\Console\Command;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'app:generate-monthly-payments {--month=} {--year=}';

    protected $description = 'Gera pagamentos mensais para despesas fixas e variáveis';

    public function handle(): int
    {
        $month = (int) ($this->option('month') ?? now()->month);
        $year = (int) ($this->option('year') ?? now()->year);

        $count = 0;

        // Despesas fixas ativas
        $fixedExpenses = FixedExpense::withoutGlobalScopes()->active()->get();
        foreach ($fixedExpenses as $expense) {
            $payment = ExpensePayment::withoutGlobalScopes()->firstOrCreate(
                [
                    'user_id' => $expense->user_id,
                    'fixed_expense_id' => $expense->id,
                    'month' => $month,
                    'year' => $year,
                ],
                [
                    'paid' => false,
                ]
            );

            if ($payment->wasRecentlyCreated) {
                $count++;
            }
        }

        // Despesas variáveis do mês
        $variableExpenses = VariableExpense::withoutGlobalScopes()
            ->whereMonth('expense_date', $month)
            ->whereYear('expense_date', $year)
            ->get();

        foreach ($variableExpenses as $expense) {
            $payment = ExpensePayment::withoutGlobalScopes()->firstOrCreate(
                [
                    'user_id' => $expense->user_id,
                    'variable_expense_id' => $expense->id,
                    'month' => $month,
                    'year' => $year,
                ],
                [
                    'paid' => false,
                ]
            );

            if ($payment->wasRecentlyCreated) {
                $count++;
            }
        }

        $this->info("Criados {$count} pagamentos para {$month}/{$year}");

        return self::SUCCESS;
    }
}
