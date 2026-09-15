<?php

namespace App\Filament\Resources\ExpensePayments\Pages;

use App\Filament\Resources\ExpensePayments\ExpensePaymentResource;
use App\Models\ExpensePayment;
use App\Models\FixedExpense;
use App\Models\Installment;
use App\Models\VariableExpense;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListExpensePayments extends ListRecords
{
    protected static string $resource = ExpensePaymentResource::class;

    public function mount(): void
    {
        parent::mount();

        $this->generateCurrentMonthPayments();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_month')
                ->label('Gerar Checklist para Outro Mês')
                ->icon('heroicon-o-calendar')
                ->form([
                    Select::make('month')
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
                    Select::make('year')
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

                    Notification::make()
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
        $fixedExpenses = FixedExpense::activeInMonth($month, $year)->get();

        foreach ($fixedExpenses as $expense) {
            ExpensePayment::createForFixedExpense($expense, $month, $year);
        }

        $variableExpenses = VariableExpense::byMonth($month, $year)->get();

        foreach ($variableExpenses as $expense) {
            ExpensePayment::createForVariableExpense($expense, $month, $year);
        }

        $installments = Installment::byMonth($month, $year)->get();

        foreach ($installments as $installment) {
            ExpensePayment::createForInstallment($installment, $month, $year);
        }
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['fixedExpense.category', 'variableExpense.category', 'installment.installmentExpense.category'])
            ->when(
                ! request()->has('tableFilters'),
                fn (Builder $query) => $query->currentMonth()
            );
    }
}
