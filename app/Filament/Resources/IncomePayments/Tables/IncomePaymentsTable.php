<?php

namespace App\Filament\Resources\IncomePayments\Tables;

use App\Filament\Exports\IncomePaymentExporter;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class IncomePaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('income_type')
                    ->label('Tipo')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Fixa' ? 'info' : 'warning')
                    ->sortable(),

                TextColumn::make('income_description')
                    ->label('Receita')
                    ->getStateUsing(fn ($record) => $record->income?->description ?? '-')
                    ->searchable(query: function ($query, $search) {
                        return $query->where(function ($query) use ($search) {
                            $query->whereHas('fixedIncome', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            })
                            ->orWhereHas('variableIncome', function ($query) use ($search) {
                                $query->where('description', 'like', "%{$search}%");
                            });
                        });
                    })
                    ->weight('bold'),

                TextColumn::make('income_category')
                    ->label('Categoria')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->income?->incomeCategory?->name ?? '-')
                    ->color(fn ($record) => $record->income?->incomeCategory?->color ?? 'gray'),

                TextColumn::make('income_amount')
                    ->label('Valor')
                    ->getStateUsing(fn ($record) => $record->income?->amount ?? 0)
                    ->money('BRL')
                    ->sortable(),

                ToggleColumn::make('received')
                    ->label('Recebido')
                    ->sortable()
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state && ! $record->payment_date) {
                            $record->payment_date = now();
                        }
                        if (! $state) {
                            $record->payment_date = null;
                        }
                    }),

                TextColumn::make('payment_date')
                    ->label('Data de Recebimento')
                    ->date('d/m/Y')
                    ->placeholder('Não recebido')
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

                SelectFilter::make('received')
                    ->label('Status')
                    ->options([
                        1 => 'Recebido',
                        0 => 'Não Recebido',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->defaultSort('id', 'asc')
            ->toolbarActions([
                BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->exporter(IncomePaymentExporter::class),
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
