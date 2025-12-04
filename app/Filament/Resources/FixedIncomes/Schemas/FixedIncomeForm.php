<?php

namespace App\Filament\Resources\FixedIncomes\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FixedIncomeForm
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

                Select::make('income_category_id')
                    ->label('Categoria')
                    ->relationship('incomeCategory', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        Textarea::make('description')
                            ->label('Descrição'),
                    ])
                    ->columnSpan(1),

                TextInput::make('amount')
                    ->label('Valor (R$)')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0)
                    ->step(0.01)
                    ->columnSpan(1),

                DatePicker::make('start_date')
                    ->label('Data de Início')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->columnSpan(1),

                TextInput::make('months_valid')
                    ->label('Validade (meses)')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->default(12)
                    ->helperText('Quantidade de meses que a receita fixa estará ativa')
                    ->columnSpan(1),

                TextInput::make('end_date')
                    ->label('Data de Término')
                    ->disabled()
                    ->dehydrated(false)
                    ->helperText('Calculado automaticamente com base na data de início e validade')
                    ->columnSpan(1),

                Toggle::make('status')
                    ->label('Ativa')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ]);
    }
}
