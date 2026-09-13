<?php

namespace App\Filament\Resources\CreditCards\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CreditCardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name')
                    ->label('Nome'),

                TextEntry::make('brand')
                    ->label('Bandeira')
                    ->formatStateUsing(fn ($state) => $state?->label() ?? '-'),

                TextEntry::make('last_four_digits')
                    ->label('Últimos 4 dígitos')
                    ->placeholder('-'),

                TextEntry::make('credit_limit')
                    ->label('Limite')
                    ->money('BRL'),

                TextEntry::make('closing_day')
                    ->label('Dia de Fechamento'),

                TextEntry::make('due_day')
                    ->label('Dia de Vencimento'),

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
