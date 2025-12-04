<?php

namespace App\Filament\Resources\FixedExpenses\Pages;

use App\Filament\Resources\FixedExpenses\FixedExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFixedExpense extends CreateRecord
{
    protected static string $resource = FixedExpenseResource::class;
}
