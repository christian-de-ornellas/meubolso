<?php

namespace App\Filament\Resources\VariableIncomes\Pages;

use App\Filament\Resources\VariableIncomes\VariableIncomeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditVariableIncome extends EditRecord
{
    protected static string $resource = VariableIncomeResource::class;

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
