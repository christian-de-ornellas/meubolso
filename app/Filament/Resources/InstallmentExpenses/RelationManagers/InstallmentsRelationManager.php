<?php

namespace App\Filament\Resources\InstallmentExpenses\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class InstallmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'installments';

    protected static ?string $title = 'Parcelas';

    protected static ?string $modelLabel = 'Parcela';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('installment_number')
                    ->label('Nº')
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL'),

                TextColumn::make('due_date')
                    ->label('Vencimento')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => !$record->paid && $record->due_date->isPast() ? 'danger' : null),

                ToggleColumn::make('paid')
                    ->label('Pago')
                    ->beforeStateUpdated(function ($record, $state) {
                        if ($state && !$record->payment_date) {
                            $record->payment_date = now();
                        }
                        if (!$state) {
                            $record->payment_date = null;
                        }
                    }),

                TextColumn::make('payment_date')
                    ->label('Data Pagamento')
                    ->date('d/m/Y')
                    ->placeholder('-'),
            ])
            ->defaultSort('installment_number', 'asc');
    }
}
