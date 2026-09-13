<?php

namespace App\Filament\Resources\Accounts\Schemas;

use App\Enums\AccountType;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(1),

                Select::make('type')
                    ->label('Tipo')
                    ->options(collect(AccountType::cases())->mapWithKeys(fn ($type) => [$type->value => $type->label()]))
                    ->required()
                    ->columnSpan(1),

                TextInput::make('bank_name')
                    ->label('Nome do Banco')
                    ->maxLength(255)
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Cor')
                    ->default('#3b82f6')
                    ->columnSpan(1),

                TextInput::make('initial_balance')
                    ->label('Saldo Inicial')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0)
                    ->step(0.01)
                    ->columnSpan(1),

                TextInput::make('current_balance')
                    ->label('Saldo Atual')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0)
                    ->step(0.01)
                    ->columnSpan(1),

                Toggle::make('status')
                    ->label('Ativa')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ]);
    }
}
