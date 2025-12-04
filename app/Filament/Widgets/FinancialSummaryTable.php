<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use App\Models\FixedIncome;
use App\Models\VariableExpense;
use App\Models\VariableIncome;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class FinancialSummaryTable extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): ?Builder
    {
        // Retornando null porque vamos usar getTableRecords() ao invés disso
        return null;
    }

    public function getTableRecords(): Collection
    {
        $records = collect();

        // Gerar os últimos 6 meses
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $month = $date->month;
            $year = $date->year;

            // Calcular receitas
            $fixedIncomes = FixedIncome::active()->sum('amount');
            $variableIncomes = VariableIncome::byMonth($month, $year)->sum('amount');
            $totalIncomes = $fixedIncomes + $variableIncomes;

            // Calcular despesas
            $fixedExpenses = FixedExpense::active()->sum('amount');
            $variableExpenses = VariableExpense::byMonth($month, $year)->sum('amount');
            $totalExpenses = $fixedExpenses + $variableExpenses;

            // Calcular saldo e taxa
            $balance = $totalIncomes - $totalExpenses;
            $savingsRate = $totalIncomes > 0 ? ($balance / $totalIncomes) * 100 : 0;

            $records->push((object) [
                'month' => $date->format('M/Y'),
                'incomes' => $totalIncomes,
                'expenses' => $totalExpenses,
                'balance' => $balance,
                'savings_rate' => $savingsRate,
            ]);
        }

        return $records;
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Resumo Financeiro Mensal (Últimos 6 Meses)')
            ->query(fn () => null)
            ->columns([
                TextColumn::make('month')
                    ->label('Mês'),

                TextColumn::make('incomes')
                    ->label('Receitas')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format($state, 2, ',', '.')),

                TextColumn::make('expenses')
                    ->label('Despesas')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format($state, 2, ',', '.')),

                TextColumn::make('balance')
                    ->label('Saldo')
                    ->formatStateUsing(fn ($state) => 'R$ ' . number_format($state, 2, ',', '.'))
                    ->color(fn ($state) => $state >= 0 ? 'success' : 'danger'),

                TextColumn::make('savings_rate')
                    ->label('Taxa de Economia')
                    ->formatStateUsing(fn ($state) => number_format($state, 1) . '%'),
            ])
            ->paginated(false);
    }
}
