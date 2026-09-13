<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccountInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('name')
                    ->label('Nome'),

                TextEntry::make('type')
                    ->label('Tipo')
                    ->formatStateUsing(fn ($state) => $state->label()),

                TextEntry::make('bank_name')
                    ->label('Banco')
                    ->placeholder('-'),

                ColorEntry::make('color')
                    ->label('Cor'),

                TextEntry::make('initial_balance')
                    ->label('Saldo Inicial')
                    ->money('BRL'),

                TextEntry::make('current_balance')
                    ->label('Saldo Atual')
                    ->money('BRL'),

                IconEntry::make('status')
                    ->label('Status')
                    ->boolean(),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
