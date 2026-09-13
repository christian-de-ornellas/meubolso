<?php

namespace App\Filament\Resources\IncomePayments\Pages;

use App\Filament\Resources\IncomePayments\IncomePaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomePayment extends EditRecord
{
    protected static string $resource = IncomePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
