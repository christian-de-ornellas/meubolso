<?php

namespace App\Filament\Widgets;

use App\Models\VariableIncome;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentVariableIncomes extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Últimas 10 Receitas Variáveis')
            ->query(
                VariableIncome::query()
                    ->with('incomeCategory')
                    ->orderBy('income_date', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('incomeCategory.name')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn ($record) => $record->incomeCategory->color ?? 'gray')
                    ->icon(fn ($record) => $record->incomeCategory->icon)
                    ->iconPosition(IconPosition::Before),

                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('income_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Observações')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->paginated([10, 25]);
    }
}
