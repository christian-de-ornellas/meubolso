<?php

namespace App\Filament\Resources\InstallmentExpenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\IconPosition;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class InstallmentExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
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

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('installment_amount')
                    ->label('Parcela')
                    ->money('BRL'),

                TextColumn::make('progress')
                    ->label('Progresso')
                    ->getStateUsing(fn ($record) => $record->paid_count . '/' . $record->installment_count)
                    ->badge()
                    ->color(fn ($record) => $record->progress_percentage >= 100 ? 'success' : ($record->progress_percentage >= 50 ? 'warning' : 'danger')),

                TextColumn::make('start_date')
                    ->label('Início')
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('creditCard.name')
                    ->label('Cartão')
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

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
