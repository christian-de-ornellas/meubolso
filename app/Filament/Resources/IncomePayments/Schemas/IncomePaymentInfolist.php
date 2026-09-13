<?php

namespace App\Filament\Resources\IncomePayments\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class IncomePaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Usuário'),
                TextEntry::make('income_type')
                    ->label('Tipo'),
                TextEntry::make('fixedIncome.description')
                    ->label('Receita Fixa')
                    ->placeholder('-'),
                TextEntry::make('variableIncome.description')
                    ->label('Receita Variável')
                    ->placeholder('-'),
                TextEntry::make('month_name')
                    ->label('Mês'),
                TextEntry::make('year')
                    ->label('Ano'),
                TextEntry::make('payment_date')
                    ->label('Data de Recebimento')
                    ->date('d/m/Y')
                    ->placeholder('-'),
                IconEntry::make('received')
                    ->label('Recebido')
                    ->boolean(),
                TextEntry::make('notes')
                    ->label('Observações')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime('d/m/Y H:i')
                    ->placeholder('-'),
            ]);
    }
}
