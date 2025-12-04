<?php

namespace App\Filament\Resources\VariableExpenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VariableExpenseInfolist
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
                    ->label('Categoria')
                    ->badge()
                    ->color(fn ($record) => $record->category->color ?? 'gray'),

                TextEntry::make('amount')
                    ->label('Valor')
                    ->money('BRL'),

                TextEntry::make('expense_date')
                    ->label('Data da Despesa')
                    ->date('d/m/Y'),

                TextEntry::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color('danger')
                    ->default('Não Programada')
                    ->formatStateUsing(fn () => 'Não Programada'),

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
