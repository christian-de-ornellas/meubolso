<?php

namespace App\Filament\Resources\FixedExpenses\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FixedExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
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

                IconEntry::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextEntry::make('start_date')
                    ->label('Data de Início')
                    ->date('d/m/Y'),

                TextEntry::make('months_valid')
                    ->label('Validade (meses)'),

                TextEntry::make('end_date')
                    ->label('Data de Término')
                    ->date('d/m/Y')
                    ->color(fn ($record) => $record->isExpiringSoon() ? 'warning' : null),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),

                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
