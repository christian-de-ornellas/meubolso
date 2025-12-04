<?php

namespace App\Filament\Widgets;

use App\Models\VariableExpense;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentVariableExpenses extends TableWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Últimas 10 Despesas Variáveis')
            ->query(
                VariableExpense::query()
                    ->with('category')
                    ->orderBy('expense_date', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('description')
                    ->label('Descrição')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->badge()
                    ->color(fn ($record) => $record->category->color ?? 'gray')
                    ->icon(fn ($record) => $record->category->icon)
                    ->iconPosition(IconPosition::Before),

                TextColumn::make('amount')
                    ->label('Valor')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('expense_date')
                    ->label('Data')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Tipo')
                    ->badge()
                    ->color('danger')
                    ->default('Não Programada')
                    ->formatStateUsing(fn () => 'Não Programada'),

                TextColumn::make('notes')
                    ->label('Observações')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->paginated([10, 25]);
    }
}
