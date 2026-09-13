<?php

namespace App\Filament\Resources\IncomePayments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class IncomePaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('income_type')
                    ->label('Tipo de Receita')
                    ->options([
                        'fixed' => 'Receita Fixa',
                        'variable' => 'Receita Variável',
                    ])
                    ->default(fn ($record) => $record?->fixed_income_id ? 'fixed' : 'variable')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('fixed_income_id', null);
                        $set('variable_income_id', null);
                    })
                    ->dehydrated(false)
                    ->columnSpanFull(),

                Select::make('fixed_income_id')
                    ->label('Receita Fixa')
                    ->relationship('fixedIncome', 'description')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('income_type') === 'fixed')
                    ->required(fn ($get) => $get('income_type') === 'fixed')
                    ->columnSpanFull(),

                Select::make('variable_income_id')
                    ->label('Receita Variável')
                    ->relationship('variableIncome', 'description')
                    ->searchable()
                    ->preload()
                    ->visible(fn ($get) => $get('income_type') === 'variable')
                    ->required(fn ($get) => $get('income_type') === 'variable')
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

                Toggle::make('received')
                    ->label('Recebido')
                    ->default(false)
                    ->columnSpanFull(),

                DatePicker::make('payment_date')
                    ->label('Data de Recebimento')
                    ->displayFormat('d/m/Y')
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label('Observações')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
