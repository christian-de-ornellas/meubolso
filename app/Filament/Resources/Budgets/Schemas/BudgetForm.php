<?php

namespace App\Filament\Resources\Budgets\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BudgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                TextInput::make('amount')
                    ->label('Valor Orçado')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0)
                    ->step(0.01)
                    ->columnSpan(1),

                Select::make('month')
                    ->label('Mês')
                    ->options([
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
                        4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                        7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
                        10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
                    ])
                    ->required()
                    ->default(now()->month)
                    ->columnSpan(1),

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
                    ->default(now()->year)
                    ->columnSpan(1),
            ]);
    }
}
