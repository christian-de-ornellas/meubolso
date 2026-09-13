<?php

namespace App\Filament\Widgets;

use App\Models\Budget;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class BudgetProgressWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Orçamento do Mês';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Budget::query()
                    ->currentMonth()
                    ->with('category')
            )
            ->columns([
                TextColumn::make('category.name')
                    ->label('Categoria'),

                TextColumn::make('amount')
                    ->label('Orçado')
                    ->money('BRL'),

                TextColumn::make('spent')
                    ->label('Gasto')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->spent)
                    ->color(fn ($record) => $record->percentage_used > 90 ? 'danger' : ($record->percentage_used > 75 ? 'warning' : 'success')),

                TextColumn::make('remaining')
                    ->label('Restante')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->remaining),

                TextColumn::make('percentage_used')
                    ->label('% Uso')
                    ->getStateUsing(fn ($record) => $record->percentage_used . '%')
                    ->badge()
                    ->color(fn ($record) => $record->percentage_used > 90 ? 'danger' : ($record->percentage_used > 75 ? 'warning' : 'success')),
            ])
            ->paginated(false);
    }
}
