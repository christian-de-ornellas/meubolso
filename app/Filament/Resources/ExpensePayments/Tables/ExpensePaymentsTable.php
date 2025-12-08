<?php

namespace App\Filament\Resources\ExpensePayments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
                    ->color(fn (string $state): string => $state === 'Fixa' ? 'info' : 'warning')
                    ->sortable(),

                TextColumn::make('expense_description')
                    ->label('Despesa')
                    ->getStateUsing(fn ($record) => $record->expense?->description ?? '-')
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($query) use ($search) {
                            $query->whereHas('fixedExpense', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            })
                            ->orWhereHas('variableExpense', function ($query) use ($search) {
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
                    ->getStateUsing(fn ($record) => $record->expense?->amount ?? 0)
                    ->money('BRL')
                    ->sortable(),

                ToggleColumn::make('paid')
                    ->label('Pago')
                    ->sortable()
                    ->beforeStateUpdated(function ($record, $state) {
                        // Quando marcar como pago, definir data de pagamento automaticamente
                        if ($state && !$record->payment_date) {
                            $record->payment_date = now();
                        }
                        // Quando desmarcar, limpar data de pagamento
                        if (!$state) {
                            $record->payment_date = null;
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
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
