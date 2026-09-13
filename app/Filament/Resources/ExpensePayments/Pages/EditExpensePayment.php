<?php

namespace App\Filament\Resources\ExpensePayments\Pages;

use App\Filament\Resources\ExpensePayments\ExpensePaymentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExpensePayment extends EditRecord
{
    protected static string $resource = ExpensePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
