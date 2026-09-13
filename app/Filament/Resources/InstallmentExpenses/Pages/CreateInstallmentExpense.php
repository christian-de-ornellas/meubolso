<?php

namespace App\Filament\Resources\InstallmentExpenses\Pages;

use App\Filament\Resources\InstallmentExpenses\InstallmentExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInstallmentExpense extends CreateRecord
{
    protected static string $resource = InstallmentExpenseResource::class;
}
