<?php

namespace App\Filament\Resources\ExpensePayments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ExpensePaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('expense_type')
                    ->label('Tipo de Despesa')
                    ->options([
                        'fixed' => 'Despesa Fixa',
                        'variable' => 'Despesa Variável',
                    ])
                    ->default(fn ($record) => $record?->fixed_expense_id ? 'fixed' : 'variable')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Limpar campos ao trocar tipo
                        $set('fixed_expense_id', null);
                        $set('variable_expense_id', null);
                    })
                    ->dehydrated(false)
                    ->columnSpanFull(),

                Select::make('fixed_expense_id')
                    ->label('Despesa Fixa')
                    ->relationship('fixedExpense', 'description')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('expense_type') === 'fixed')
                    ->required(fn ($get) => $get('expense_type') === 'fixed')
                    ->columnSpanFull(),

                Select::make('variable_expense_id')
                    ->label('Despesa Variável')
                    ->relationship('variableExpense', 'description')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('expense_type') === 'variable')
                    ->required(fn ($get) => $get('expense_type') === 'variable')
                    ->columnSpanFull(),

                Select::make('month')
                    ->label('Mês')
                    ->options([
                        1 => 'Janeiro',
                        2 => 'Fevereiro',
                        3 => 'Março',
                        4 => 'Abril',
                        5 => 'Maio',
                        6 => 'Junho',
                        7 => 'Julho',
                        8 => 'Agosto',
                        9 => 'Setembro',
                        10 => 'Outubro',
                        11 => 'Novembro',
                        12 => 'Dezembro',
                    ])
                    ->required()
                    ->default(now()->month),

                Select::make('year')
                    ->label('Ano')
                    ->options(function () {
                        $currentYear = now()->year;
                        $years = [];
                        for ($i = $currentYear - 1; $i <= $currentYear + 2; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->required()
                    ->default(now()->year),

                Toggle::make('paid')
                    ->label('Pago')
                    ->default(false)
                    ->columnSpanFull(),

                DatePicker::make('payment_date')
                    ->label('Data de Pagamento')
                    ->displayFormat('d/m/Y')
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label('Observações')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
