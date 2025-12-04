<?php

namespace App\Filament\Resources\VariableIncomes\Pages;

use App\Filament\Resources\VariableIncomes\VariableIncomeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewVariableIncome extends ViewRecord
{
    protected static string $resource = VariableIncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
