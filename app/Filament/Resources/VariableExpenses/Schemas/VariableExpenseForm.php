<?php

namespace App\Filament\Resources\VariableExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VariableExpenseForm
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

                DatePicker::make('expense_date')
                    ->label('Data da Despesa')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
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

                Textarea::make('notes')
                    ->label('Observações')
                    ->rows(3)
                    ->columnSpanFull(),

                Select::make('tags')
                    ->label('Tags')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),

                FileUpload::make('attachment')
                    ->label('Comprovante')
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->maxSize(5120)
                    ->directory('comprovantes')
                    ->columnSpanFull(),
            ]);
    }
}
