<?php

namespace App\Filament\Resources\InstallmentExpenses\Pages;

use App\Filament\Resources\InstallmentExpenses\InstallmentExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditInstallmentExpense extends EditRecord
{
    protected static string $resource = InstallmentExpenseResource::class;

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
