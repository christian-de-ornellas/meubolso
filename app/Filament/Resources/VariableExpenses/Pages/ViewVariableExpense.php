<?php

namespace App\Filament\Resources\VariableExpenses\Pages;

use App\Filament\Resources\VariableExpenses\VariableExpenseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVariableExpense extends ViewRecord
{
    protected static string $resource = VariableExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
