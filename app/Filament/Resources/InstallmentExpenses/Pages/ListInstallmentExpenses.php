<?php

namespace App\Filament\Resources\InstallmentExpenses\Pages;

use App\Filament\Resources\InstallmentExpenses\InstallmentExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInstallmentExpenses extends ListRecords
{
    protected static string $resource = InstallmentExpenseResource::class;

    protected string $view = 'filament.resources.installment-expenses.pages.list-installment-expenses';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
