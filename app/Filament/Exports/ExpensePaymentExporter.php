<?php

namespace App\Filament\Exports;

use App\Models\ExpensePayment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ExpensePaymentExporter extends Exporter
{
    protected static ?string $model = ExpensePayment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('expense_type')
                ->label('Tipo'),
            ExportColumn::make('expense_description')
                ->label('Despesa')
                ->getStateUsing(fn ($record) => $record->expense?->description ?? '-'),
            ExportColumn::make('expense_amount')
                ->label('Valor')
                ->getStateUsing(fn ($record) => 'R$ ' . number_format($record->expense?->amount ?? 0, 2, ',', '.')),
            ExportColumn::make('month')
                ->label('Mês'),
            ExportColumn::make('year')
                ->label('Ano'),
            ExportColumn::make('paid')
                ->label('Pago')
                ->formatStateUsing(fn ($state) => $state ? 'Sim' : 'Não'),
            ExportColumn::make('payment_date')
                ->label('Data Pagamento')
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y')),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'A exportação de pagamentos foi concluída com ' . number_format($export->successful_rows) . ' ' . str('registro')->plural($export->successful_rows) . '.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('registro')->plural($failedRowsCount) . ' falharam.';
        }

        return $body;
    }
}
