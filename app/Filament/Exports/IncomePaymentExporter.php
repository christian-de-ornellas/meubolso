<?php

namespace App\Filament\Exports;

use App\Models\IncomePayment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class IncomePaymentExporter extends Exporter
{
    protected static ?string $model = IncomePayment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('income_type')
                ->label('Tipo'),
            ExportColumn::make('income_description')
                ->label('Receita')
                ->getStateUsing(fn ($record) => $record->income?->description ?? '-'),
            ExportColumn::make('income_amount')
                ->label('Valor')
                ->getStateUsing(fn ($record) => 'R$ ' . number_format($record->income?->amount ?? 0, 2, ',', '.')),
            ExportColumn::make('month')
                ->label('Mês'),
            ExportColumn::make('year')
                ->label('Ano'),
            ExportColumn::make('received')
                ->label('Recebido')
                ->formatStateUsing(fn ($state) => $state ? 'Sim' : 'Não'),
            ExportColumn::make('payment_date')
                ->label('Data Recebimento')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de recebimentos foi concluída com ' . number_format($export->successful_rows) . ' ' . str('registro')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('registro')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
