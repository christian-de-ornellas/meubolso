<?php

namespace App\Filament\Resources\IncomePayments\Pages;

use App\Filament\Resources\IncomePayments\IncomePaymentResource;
use App\Models\FixedIncome;
use App\Models\IncomePayment;
use App\Models\VariableIncome;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListIncomePayments extends ListRecords
{
    protected static string $resource = IncomePaymentResource::class;

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
        $fixedIncomes = FixedIncome::activeInMonth($month, $year)->get();

        foreach ($fixedIncomes as $income) {
            IncomePayment::createForFixedIncome($income, $month, $year);
        }

        $variableIncomes = VariableIncome::byMonth($month, $year)->get();

        foreach ($variableIncomes as $income) {
            IncomePayment::createForVariableIncome($income, $month, $year);
        }
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->active()
            ->with(['fixedIncome.incomeCategory', 'variableIncome.incomeCategory'])
            ->when(
                ! request()->has('tableFilters'),
                fn (Builder $query) => $query->currentMonth()
            );
    }
}
