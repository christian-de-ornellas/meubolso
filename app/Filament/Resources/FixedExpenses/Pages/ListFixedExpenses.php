<?php

namespace App\Filament\Resources\FixedExpenses\Pages;

use App\Filament\Resources\FixedExpenses\FixedExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFixedExpenses extends ListRecords
{
    protected static string $resource = FixedExpenseResource::class;

    protected string $view = 'filament.resources.fixed-expenses.pages.list-fixed-expenses';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
