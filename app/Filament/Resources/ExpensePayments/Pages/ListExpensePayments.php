<?php

namespace App\Filament\Resources\ExpensePayments\Pages;

use App\Filament\Resources\ExpensePayments\ExpensePaymentResource;
use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListExpensePayments extends ListRecords
{
    protected static string $resource = ExpensePaymentResource::class;

    public function mount(): void
    {
        parent::mount();

        // Gerar automaticamente registros para despesas fixas ativas do mês atual
        $this->generateCurrentMonthPayments();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_month')
                ->label('Gerar Checklist para Outro Mês')
                ->icon('heroicon-o-calendar')
                ->form([
                    \Filament\Forms\Components\Select::make('month')
                        ->label('Mês')
                        ->options([
                            1 => 'Janeiro',
                            2 => 'Fevereiro',
                            3 => 'Março',
                            4 => 'Abril',
                            5 => 'Maio',
                            6 => 'Junho',
                            7 => 'Julho',
                            8 => 'Agosto',
                            9 => 'Setembro',
                            10 => 'Outubro',
                            11 => 'Novembro',
                            12 => 'Dezembro',
                        ])
                        ->default(now()->month)
                        ->required(),
                    \Filament\Forms\Components\Select::make('year')
                        ->label('Ano')
                        ->options(function () {
                            $currentYear = now()->year;
                            $years = [];
                            for ($i = $currentYear - 1; $i <= $currentYear + 2; $i++) {
                                $years[$i] = $i;
                            }
                            return $years;
                        })
                        ->default(now()->year)
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->generatePaymentsForMonth($data['month'], $data['year']);

                    \Filament\Notifications\Notification::make()
                        ->title('Checklist gerado')
                        ->body("Checklist criado para {$data['month']}/{$data['year']}")
                        ->success()
                        ->send();
                }),
        ];
    }

    protected function generateCurrentMonthPayments(): void
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $this->generatePaymentsForMonth($currentMonth, $currentYear);
    }

    protected function generatePaymentsForMonth(int $month, int $year): void
    {
        // Buscar todas as despesas fixas ativas do usuário
        $fixedExpenses = FixedExpense::active()->get();

        foreach ($fixedExpenses as $expense) {
            // Verificar se já existe um registro de pagamento para esta despesa neste mês
            ExpensePayment::firstOrCreate([
                'user_id' => auth()->id(),
                'fixed_expense_id' => $expense->id,
                'month' => $month,
                'year' => $year,
            ], [
                'paid' => false,
            ]);
        }
    }

    protected function getTableQuery(): Builder
    {
        // Por padrão, mostrar apenas o mês atual
        return parent::getTableQuery()
            ->with(['fixedExpense.category'])
            ->when(
                !request()->has('tableFilters'),
                fn (Builder $query) => $query->currentMonth()
            );
    }
}
