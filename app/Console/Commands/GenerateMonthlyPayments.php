<?php

namespace App\Console\Commands;

use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\User;
use App\Models\VariableExpense;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class GenerateMonthlyPayments extends Command
{
    protected $signature = 'app:generate-monthly-payments {--month=} {--year=}';

    protected $description = 'Gera pagamentos mensais para despesas fixas e variáveis';

    public function handle(): int
    {
        $month = (int) ($this->option('month') ?? now()->month);
        $year = (int) ($this->option('year') ?? now()->year);

        $count = 0;

        User::chunk(100, function ($users) use ($month, $year, &$count) {
            foreach ($users as $user) {
                Auth::setUser($user);

                // Despesas fixas ativas
                $fixedExpenses = FixedExpense::active()->get();
                foreach ($fixedExpenses as $expense) {
                    $payment = ExpensePayment::firstOrCreate(
                        [
                            'user_id' => $user->id,
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
                $variableExpenses = VariableExpense::query()
                    ->whereMonth('expense_date', $month)
                    ->whereYear('expense_date', $year)
                    ->get();

                foreach ($variableExpenses as $expense) {
                    $payment = ExpensePayment::firstOrCreate(
                        [
                            'user_id' => $user->id,
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
            }
        });

        Auth::forgetUser();

        $this->info("Criados {$count} pagamentos para {$month}/{$year}");

        return self::SUCCESS;
    }
}
