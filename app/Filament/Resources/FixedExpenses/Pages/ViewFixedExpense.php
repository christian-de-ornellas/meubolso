<?php

namespace App\Filament\Resources\FixedExpenses\Pages;

use App\Filament\Resources\FixedExpenses\FixedExpenseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFixedExpense extends ViewRecord
{
    protected static string $resource = FixedExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
