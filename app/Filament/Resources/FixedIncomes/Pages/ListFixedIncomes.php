<?php

namespace App\Filament\Resources\FixedIncomes\Pages;

use App\Filament\Resources\FixedIncomes\FixedIncomeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFixedIncomes extends ListRecords
{
    protected static string $resource = FixedIncomeResource::class;

    protected string $view = 'filament.resources.fixed-incomes.pages.list-fixed-incomes';

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
