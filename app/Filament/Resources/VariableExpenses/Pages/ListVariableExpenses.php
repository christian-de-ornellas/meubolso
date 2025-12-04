<?php

namespace App\Filament\Resources\VariableExpenses\Pages;

use App\Filament\Resources\VariableExpenses\VariableExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVariableExpenses extends ListRecords
{
    protected static string $resource = VariableExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
