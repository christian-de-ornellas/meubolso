<?php

namespace App\Filament\Resources\InstallmentExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InstallmentExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('description')
                    ->label('Descrição')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                Select::make('account_id')
                    ->label('Conta')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                Select::make('credit_card_id')
                    ->label('Cartão de Crédito')
                    ->relationship('creditCard', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                TextInput::make('total_amount')
                    ->label('Valor Total')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0)
                    ->step(0.01)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $count = $get('installment_count');
                        if ($state && $count && $count > 0) {
                            $set('installment_amount', round($state / $count, 2));
                        }
                    })
                    ->columnSpan(1),

                TextInput::make('installment_count')
                    ->label('Número de Parcelas')
                    ->required()
                    ->numeric()
                    ->minValue(2)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $total = $get('total_amount');
                        if ($total && $state && $state > 0) {
                            $set('installment_amount', round($total / $state, 2));
                        }
                    })
                    ->columnSpan(1),

                TextInput::make('installment_amount')
                    ->label('Valor da Parcela')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->step(0.01)
                    ->columnSpan(1),

                DatePicker::make('start_date')
                    ->label('Data da Primeira Parcela')
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
