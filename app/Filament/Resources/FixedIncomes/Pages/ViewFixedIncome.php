<?php

namespace App\Filament\Resources\FixedIncomes\Pages;

use App\Filament\Resources\FixedIncomes\FixedIncomeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFixedIncome extends ViewRecord
{
    protected static string $resource = FixedIncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
