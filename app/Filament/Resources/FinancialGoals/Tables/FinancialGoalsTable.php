<?php

namespace App\Filament\Resources\FinancialGoals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class FinancialGoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('target_amount')
                    ->label('Valor Alvo')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('current_amount')
                    ->label('Valor Atual')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('progress_percentage')
                    ->label('Progresso')
                    ->getStateUsing(fn ($record) => $record->progress_percentage . '%')
                    ->badge()
                    ->color(fn ($record) => $record->progress_percentage >= 100 ? 'success' : ($record->progress_percentage >= 50 ? 'warning' : 'danger')),

                TextColumn::make('deadline')
                    ->label('Prazo')
                    ->date('d/m/Y')
                    ->placeholder('-')
                    ->sortable(),

                IconColumn::make('status')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                TernaryFilter::make('status')
                    ->label('Status')
                    ->placeholder('Todas')
                    ->trueLabel('Ativas')
                    ->falseLabel('Inativas'),

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
            ->defaultSort('created_at', 'desc');
    }
}
