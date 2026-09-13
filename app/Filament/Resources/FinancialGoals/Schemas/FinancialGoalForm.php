<?php

namespace App\Filament\Resources\FinancialGoals\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FinancialGoalForm
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
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Descrição')
                    ->rows(3)
                    ->columnSpanFull(),

                TextInput::make('target_amount')
                    ->label('Valor Alvo')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0)
                    ->step(0.01)
                    ->columnSpan(1),

                TextInput::make('current_amount')
                    ->label('Valor Atual')
                    ->numeric()
                    ->prefix('R$')
                    ->default(0)
                    ->step(0.01)
                    ->columnSpan(1),

                DatePicker::make('deadline')
                    ->label('Prazo')
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->columnSpan(1),

                ColorPicker::make('color')
                    ->label('Cor')
                    ->default('#3b82f6')
                    ->columnSpan(1),

                Toggle::make('status')
                    ->label('Ativa')
                    ->default(true)
                    ->inline(false)
                    ->columnSpan(1),
            ]);
    }
}
