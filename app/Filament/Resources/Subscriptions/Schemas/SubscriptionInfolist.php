<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use Filament\Infolists\Components\ColorEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SubscriptionInfolist
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

                TextEntry::make('category.name')
                    ->label('Categoria')
                    ->placeholder('-'),

                TextEntry::make('account.name')
                    ->label('Conta')
                    ->placeholder('-'),

                TextEntry::make('amount')
                    ->label('Valor')
                    ->money('BRL'),

                TextEntry::make('billing_cycle')
                    ->label('Ciclo')
                    ->formatStateUsing(fn ($state) => $state->label()),

                TextEntry::make('monthly_equivalent')
                    ->label('Equivalente Mensal')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->monthly_equivalent),

                TextEntry::make('start_date')
                    ->label('Data de Início')
                    ->date('d/m/Y'),

                TextEntry::make('next_billing_date')
                    ->label('Próxima Cobrança')
                    ->date('d/m/Y')
                    ->placeholder('-'),

                TextEntry::make('url')
                    ->label('URL')
                    ->placeholder('-')
                    ->url(fn ($state) => $state),

                ColorEntry::make('color')
                    ->label('Cor'),

                IconEntry::make('status')
                    ->label('Status')
                    ->boolean(),
            ]);
    }
}
