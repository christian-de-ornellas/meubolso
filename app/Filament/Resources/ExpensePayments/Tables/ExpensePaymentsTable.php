<?php

namespace App\Filament\Resources\ExpensePayments\Tables;

use App\Filament\Exports\ExpensePaymentExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExpensePaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('expense_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Fixa' => 'info',
                        'Parcelamento' => 'success',
                        default => 'warning',
                    })
                    ->sortable(),

                TextColumn::make('expense_description')
                    ->label('Despesa')
                    ->getStateUsing(function ($record) {
                        if ($record->installment_id) {
                            $expense = $record->installment?->installmentExpense;
                            $number = $record->installment?->installment_number;
                            $total = $expense?->installment_count;

                            return $expense ? "{$expense->description} {$number}/{$total}" : '-';
                        }

                        return $record->expense?->description ?? '-';
                    })
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($query) use ($search) {
                            $query->whereHas('fixedExpense', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            })
                            ->orWhereHas('variableExpense', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            })
                            ->orWhereHas('installment.installmentExpense', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            });
                        });
                    })
                    ->weight('bold'),

                TextColumn::make('expense_category')
                    ->label('Categoria')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->expense?->category?->name ?? '-')
                    ->color(fn ($record) => $record->expense?->category?->color ?? 'gray'),

                TextColumn::make('expense_amount')
                    ->label('Valor')
                    ->getStateUsing(function ($record) {
                        if ($record->installment_id) {
                            return $record->installment?->amount ?? 0;
                        }

                        return $record->expense?->amount ?? 0;
                    })
                    ->money('BRL')
                    ->sortable(),

                ToggleColumn::make('paid')
                    ->label('Pago')
                    ->sortable()
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state && !$record->payment_date) {
                            $record->payment_date = now();
                        }
                        if (!$state) {
                            $record->payment_date = null;
                        }
                    })
                    ->afterStateUpdated(function ($record, $state) {
                        if ($record->installment_id && $record->installment) {
                            $record->installment->update([
                                'paid' => $state,
                                'payment_date' => $state ? now() : null,
                            ]);
                        }
                    }),

                TextColumn::make('payment_date')
                    ->label('Data de Pagamento')
                    ->date('d/m/Y')
                    ->placeholder('Não pago')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Observações')
                    ->limit(50)
                    ->placeholder('-')
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('month')
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
                    ->default(now()->month),

                SelectFilter::make('year')
                    ->label('Ano')
                    ->options(function () {
                        $currentYear = now()->year;
                        $years = [];
                        for ($i = $currentYear - 2; $i <= $currentYear + 1; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->default(now()->year),

                SelectFilter::make('paid')
                    ->label('Status')
                    ->options([
                        1 => 'Pago',
                        0 => 'Não Pago',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('id', 'asc')
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(ExpensePaymentExporter::class),
                    BulkAction::make('dismiss')
                        ->label('Remover')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(fn (Collection $records) => $records->each->update(['dismissed' => true])),
                ]),
            ]);
    }
}
