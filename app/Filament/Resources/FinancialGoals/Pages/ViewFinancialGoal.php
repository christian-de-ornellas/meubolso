<?php

namespace App\Filament\Resources\FinancialGoals\Pages;

use App\Filament\Resources\FinancialGoals\FinancialGoalResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFinancialGoal extends ViewRecord
{
    protected static string $resource = FinancialGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
