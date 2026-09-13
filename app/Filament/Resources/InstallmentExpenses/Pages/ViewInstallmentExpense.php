<?php

namespace App\Filament\Resources\InstallmentExpenses\Pages;

use App\Filament\Resources\InstallmentExpenses\InstallmentExpenseResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstallmentExpense extends ViewRecord
{
    protected static string $resource = InstallmentExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
