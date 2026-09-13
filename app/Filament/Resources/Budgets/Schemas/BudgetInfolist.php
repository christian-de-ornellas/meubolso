<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BudgetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('category.name')
                    ->label('Categoria'),

                TextEntry::make('amount')
                    ->label('Valor Orçado')
                    ->money('BRL'),

                TextEntry::make('month')
                    ->label('Mês')
                    ->formatStateUsing(fn ($state) => [
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
                        4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                        7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
                        10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
                    ][$state] ?? $state),

                TextEntry::make('year')
                    ->label('Ano'),

                TextEntry::make('spent')
                    ->label('Gasto')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->spent),

                TextEntry::make('remaining')
                    ->label('Restante')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->remaining),
            ]);
    }
}
