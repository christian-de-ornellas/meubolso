<?php

namespace App\Filament\Resources\ExpensePayments\Pages;

use App\Filament\Resources\ExpensePayments\ExpensePaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpensePayment extends CreateRecord
{
    protected static string $resource = ExpensePaymentResource::class;
}
