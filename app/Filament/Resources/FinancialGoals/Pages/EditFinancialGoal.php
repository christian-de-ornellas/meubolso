<?php

namespace App\Filament\Resources\FinancialGoals\Pages;

use App\Filament\Resources\FinancialGoals\FinancialGoalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFinancialGoal extends EditRecord
{
    protected static string $resource = FinancialGoalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
