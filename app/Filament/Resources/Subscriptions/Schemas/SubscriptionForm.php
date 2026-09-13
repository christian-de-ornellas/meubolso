<?php

namespace App\Filament\Resources\Subscriptions\Schemas;

use App\Enums\BillingCycle;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SubscriptionForm
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

                Select::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                Select::make('account_id')
                    ->label('Conta')
                    ->relationship('account', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpan(1),

                TextInput::make('amount')
                    ->label('Valor')
                    ->required()
                    ->numeric()
                    ->prefix('R$')
                    ->minValue(0)
                    ->step(0.01)
                    ->columnSpan(1),

                Select::make('billing_cycle')
                    ->label('Ciclo de Cobrança')
                    ->options(collect(BillingCycle::cases())->mapWithKeys(fn ($cycle) => [$cycle->value => $cycle->label()]))
                    ->required()
                    ->columnSpan(1),

                DatePicker::make('start_date')
                    ->label('Data de Início')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y')
                    ->columnSpan(1),

                TextInput::make('url')
                    ->label('URL')
                    ->url()
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
