<?php

namespace App\Filament\Resources\VariableIncomes\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VariableIncomeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('description')
                    ->label('Descrição')
                    ->columnSpanFull(),

                TextEntry::make('incomeCategory.name')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn ($record) => $record->incomeCategory->color ?? 'gray'),

                TextEntry::make('amount')
                    ->label('Valor')
                    ->money('BRL'),

                TextEntry::make('income_date')
                    ->label('Data da Receita')
                    ->date('d/m/Y'),

                TextEntry::make('notes')
                    ->label('Observações')
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),

                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
