<?php

namespace App\Filament\Resources\IncomePayments\Pages;

use App\Filament\Resources\IncomePayments\IncomePaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIncomePayment extends CreateRecord
{
    protected static string $resource = IncomePaymentResource::class;
}
