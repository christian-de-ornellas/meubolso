<?php

namespace App\Filament\Exports;

use App\Models\VariableIncome;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class VariableIncomeExporter extends Exporter
{
    protected static ?string $model = VariableIncome::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('description')
                ->label('Descrição'),
            ExportColumn::make('incomeCategory.name')
                ->label('Categoria'),
            ExportColumn::make('amount')
                ->label('Valor')
                ->formatStateUsing(fn ($state) => 'R$ ' . number_format($state, 2, ',', '.')),
            ExportColumn::make('income_date')
                ->label('Data')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y')),
            ExportColumn::make('notes')
                ->label('Observações'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de receitas variáveis foi concluída com ' . number_format($export->successful_rows) . ' ' . str('registro')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('registro')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
