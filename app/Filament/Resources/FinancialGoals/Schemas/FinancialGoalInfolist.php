<?php

namespace App\Filament\Resources\FinancialGoals\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class FinancialGoalInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name')
                    ->label('Nome'),

                TextEntry::make('description')
                    ->label('Descrição')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('target_amount')
                    ->label('Valor Alvo')
                    ->money('BRL'),

                TextEntry::make('current_amount')
                    ->label('Valor Atual')
                    ->money('BRL'),

                TextEntry::make('progress_percentage')
                    ->label('Progresso')
                    ->getStateUsing(fn ($record) => $record->progress_percentage . '%'),

                TextEntry::make('remaining_amount')
                    ->label('Faltam')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->remaining_amount),

                TextEntry::make('deadline')
                    ->label('Prazo')
                    ->date('d/m/Y')
                    ->placeholder('-'),

                ColorEntry::make('color')
                    ->label('Cor'),

                IconEntry::make('status')
                    ->label('Status')
                    ->boolean(),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
