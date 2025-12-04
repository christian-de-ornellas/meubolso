<?php

namespace App\Filament\Widgets;

use App\Models\FixedExpense;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class UpcomingFixedExpenses extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Despesas Fixas Vencendo nos Próximos 30 Dias')
            ->query(
                FixedExpense::query()
                    ->expiringSoon(30)
                    ->with('category')
                    ->orderBy('end_date', 'asc')
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

                TextColumn::make('end_date')
                    ->label('Data de Vencimento')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color('warning')
                    ->icon('heroicon-o-exclamation-triangle')
                    ->iconPosition(IconPosition::Before),

                TextColumn::make('days_until_expiry')
                    ->label('Dias Restantes')
                    ->getStateUsing(fn ($record) => $record->end_date->diffInDays(now()) . ' dias')
                    ->badge()
                    ->color(fn ($record) => $record->end_date->diffInDays(now()) <= 7 ? 'danger' : 'warning'),
            ])
            ->paginated([5, 10, 25]);
    }
}
