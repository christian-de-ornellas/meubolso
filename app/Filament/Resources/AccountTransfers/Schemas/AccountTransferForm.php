<?php

namespace App\Filament\Resources\AccountTransfers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountTransferForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('from_account_id')
                    ->label('Conta de Origem')
                    ->relationship('fromAccount', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                Select::make('to_account_id')
                    ->label('Conta de Destino')
                    ->relationship('toAccount', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->different('from_account_id')
                    ->columnSpan(1),

                TextInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0.01)
                    ->step(0.01)
                    ->columnSpan(1),

                DatePicker::make('transfer_date')
                    ->label('Data da Transferência')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->columnSpan(1),

                Textarea::make('notes')
                    ->label('Observações')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
