<?php

namespace App\Filament\Resources\InstallmentExpenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class InstallmentExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),

                TextEntry::make('category.name')
                    ->label('Categoria'),

                TextEntry::make('account.name')
                    ->label('Conta')
                    ->placeholder('-'),

                TextEntry::make('creditCard.name')
                    ->label('Cartão')
                    ->placeholder('-'),

                TextEntry::make('total_amount')
                    ->label('Valor Total')
                    ->money('BRL'),

                TextEntry::make('installment_count')
                    ->label('Parcelas'),

                TextEntry::make('installment_amount')
                    ->label('Valor da Parcela')
                    ->money('BRL'),

                TextEntry::make('start_date')
                    ->label('Primeira Parcela')
                    ->date('d/m/Y'),

                TextEntry::make('progress_percentage')
                    ->label('Progresso')
                    ->getStateUsing(fn ($record) => $record->paid_count . '/' . $record->installment_count . ' (' . $record->progress_percentage . '%)'),

                TextEntry::make('notes')
                    ->label('Observações')
                    ->placeholder('-')
                    ->columnSpanFull(),
            ]);
    }
}
