<?php

namespace App\Filament\Resources\Budgets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class BudgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->label('Categoria')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('Orçado')
                    ->money('BRL')
                    ->sortable(),

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

                TextColumn::make('month')
                    ->label('Mês')
                    ->formatStateUsing(fn ($state) => [
                        1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr',
                        5 => 'Mai', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
                        9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez',
                    ][$state] ?? $state),

                TextColumn::make('year')
                    ->label('Ano'),
            ])
            ->filters([
                SelectFilter::make('month')
                    ->label('Mês')
                    ->options([
                        1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março',
                        4 => 'Abril', 5 => 'Maio', 6 => 'Junho',
                        7 => 'Julho', 8 => 'Agosto', 9 => 'Setembro',
                        10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro',
                    ])
                    ->default(now()->month),

                SelectFilter::make('year')
                    ->label('Ano')
                    ->options(function () {
                        $currentYear = now()->year;
                        $years = [];
                        for ($i = $currentYear - 2; $i <= $currentYear + 1; $i++) {
                            $years[$i] = $i;
                        }
                        return $years;
                    })
                    ->default(now()->year),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('category_id', 'asc');
    }
}
