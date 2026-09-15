<?php

namespace App\Filament\Resources\ExpensePayments\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExpensePaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Usuário'),
                TextEntry::make('expense_type')
                    ->label('Tipo'),
                TextEntry::make('fixedExpense.description')
                    ->label('Despesa Fixa')
                    ->visible(fn ($record) => $record->fixed_expense_id !== null)
                    ->placeholder('-'),
                TextEntry::make('variableExpense.description')
                    ->label('Despesa Variável')
                    ->visible(fn ($record) => $record->variable_expense_id !== null)
                    ->placeholder('-'),
                TextEntry::make('installment_detail')
                    ->label('Parcela')
                    ->getStateUsing(function ($record) {
                        if (! $record->installment_id) {
                            return null;
                        }
                        $installment = $record->installment;
                        $expense = $installment?->installmentExpense;

                        return $expense
                            ? "{$expense->description} - Parcela {$installment->installment_number}/{$expense->installment_count}"
                            : '-';
                    })
                    ->visible(fn ($record) => $record->installment_id !== null)
                    ->placeholder('-'),
                TextEntry::make('month')
                    ->numeric(),
                TextEntry::make('year')
                    ->numeric(),
                TextEntry::make('payment_date')
                    ->date()
                    ->placeholder('-'),
                IconEntry::make('paid')
                    ->boolean(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
