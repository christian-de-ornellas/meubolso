<?php

namespace App\Filament\Resources\AccountTransfers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AccountTransferInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextEntry::make('fromAccount.name')
                    ->label('Conta de Origem'),

                TextEntry::make('toAccount.name')
                    ->label('Conta de Destino'),

                TextEntry::make('amount')
                    ->label('Valor')
                    ->money('BRL'),

                TextEntry::make('transfer_date')
                    ->label('Data da Transferência')
                    ->date('d/m/Y'),

                TextEntry::make('notes')
                    ->label('Observações')
                    ->placeholder('-')
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i'),
            ]);
    }
}
