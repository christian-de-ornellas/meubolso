<?php

namespace App\Filament\Resources\IncomePayments\Pages;

use App\Filament\Resources\IncomePayments\IncomePaymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIncomePayment extends ViewRecord
{
    protected static string $resource = IncomePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
