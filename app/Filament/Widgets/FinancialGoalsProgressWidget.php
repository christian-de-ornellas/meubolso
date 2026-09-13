<?php

namespace App\Filament\Widgets;

use App\Models\FinancialGoal;
use Filament\Widgets\TableWidget;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FinancialGoalsProgressWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected static ?string $heading = 'Metas Financeiras';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                FinancialGoal::query()->active()
            )
            ->columns([
                TextColumn::make('name')
                    ->label('Meta'),

                TextColumn::make('target_amount')
                    ->label('Alvo')
                    ->money('BRL'),

                TextColumn::make('current_amount')
                    ->label('Atual')
                    ->money('BRL'),

                TextColumn::make('remaining_amount')
                    ->label('Faltam')
                    ->money('BRL')
                    ->getStateUsing(fn ($record) => $record->remaining_amount),

                TextColumn::make('progress_percentage')
                    ->label('Progresso')
                    ->getStateUsing(fn ($record) => $record->progress_percentage . '%')
                    ->badge()
                    ->color(fn ($record) => $record->progress_percentage >= 100 ? 'success' : ($record->progress_percentage >= 50 ? 'warning' : 'danger')),

                TextColumn::make('deadline')
                    ->label('Prazo')
                    ->date('d/m/Y')
                    ->placeholder('-'),
            ])
            ->paginated(false);
    }
}
