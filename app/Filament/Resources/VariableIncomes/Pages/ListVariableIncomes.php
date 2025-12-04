<?php

namespace App\Filament\Resources\VariableIncomes\Pages;

use App\Filament\Resources\VariableIncomes\VariableIncomeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVariableIncomes extends ListRecords
{
    protected static string $resource = VariableIncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
