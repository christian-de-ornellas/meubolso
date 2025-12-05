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
            ->heading('Próximos Vencimentos de Despesas Fixas (30 Dias)')
            ->query(
                FixedExpense::query()
                    ->active()
                    ->with('category')
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

                TextColumn::make('next_due_date')
                    ->label('Próximo Vencimento')
                    ->getStateUsing(function ($record) {
                        $today = now();
                        $dayOfMonth = $record->start_date->day;

                        // Calcular o próximo vencimento
                        $nextDue = now()->day($dayOfMonth);

                        // Se o dia já passou neste mês, pega o próximo mês
                        if ($nextDue->isPast()) {
                            $nextDue = $nextDue->addMonth();
                        }

                        return $nextDue->format('d/m/Y');
                    })
                    ->sortable()
                    ->color('warning')
                    ->icon('heroicon-o-calendar')
                    ->iconPosition(IconPosition::Before),

                TextColumn::make('days_until_due')
                    ->label('Dias Restantes')
                    ->getStateUsing(function ($record) {
                        $today = now()->startOfDay();
                        $dayOfMonth = $record->start_date->day;

                        $nextDue = now()->day($dayOfMonth)->startOfDay();
                        if ($nextDue->isPast()) {
                            $nextDue = $nextDue->addMonth();
                        }

                        $daysUntil = (int) $today->diffInDays($nextDue);

                        return $daysUntil . ($daysUntil === 1 ? ' dia' : ' dias');
                    })
                    ->badge()
                    ->color(function ($record) {
                        $today = now()->startOfDay();
                        $dayOfMonth = $record->start_date->day;

                        $nextDue = now()->day($dayOfMonth)->startOfDay();
                        if ($nextDue->isPast()) {
                            $nextDue = $nextDue->addMonth();
                        }

                        $daysUntil = (int) $today->diffInDays($nextDue);

                        if ($daysUntil <= 7) return 'danger';
                        if ($daysUntil <= 15) return 'warning';
                        return 'success';
                    }),
            ])
            ->defaultSort(fn ($query) => $query->orderByRaw('
                CASE
                    WHEN (CAST(strftime("%d", start_date) AS INTEGER) - CAST(strftime("%d", "now") AS INTEGER)) >= 0
                    THEN (CAST(strftime("%d", start_date) AS INTEGER) - CAST(strftime("%d", "now") AS INTEGER))
                    ELSE (CAST(strftime("%d", start_date) AS INTEGER) - CAST(strftime("%d", "now") AS INTEGER) + 30)
                END
            '))
            ->paginated([5, 10, 25]);
    }
}
