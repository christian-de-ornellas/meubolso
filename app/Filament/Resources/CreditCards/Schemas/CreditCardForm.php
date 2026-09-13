<?php

namespace App\Filament\Resources\CreditCards\Schemas;

use App\Enums\CardBrand;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CreditCardForm
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

                Select::make('brand')
                    ->label('Bandeira')
                    ->options(collect(CardBrand::cases())->mapWithKeys(fn ($brand) => [$brand->value => $brand->label()]))
                    ->searchable()
                    ->columnSpan(1),

                TextInput::make('last_four_digits')
                    ->label('Últimos 4 dígitos')
                    ->maxLength(4)
                    ->columnSpan(1),

                TextInput::make('credit_limit')
                    ->label('Limite')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0)
                    ->step(0.01)
                    ->columnSpan(1),

                TextInput::make('closing_day')
                    ->label('Dia de Fechamento')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(31)
                    ->columnSpan(1),

                TextInput::make('due_day')
                    ->label('Dia de Vencimento')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(31)
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Cor')
                    ->default('#3b82f6')
                    ->columnSpan(1),

                Toggle::make('status')
                    ->label('Ativo')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ]);
    }
}
