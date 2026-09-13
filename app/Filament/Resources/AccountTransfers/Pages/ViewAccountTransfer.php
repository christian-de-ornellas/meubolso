<?php

namespace App\Filament\Resources\AccountTransfers\Pages;

use App\Filament\Resources\AccountTransfers\AccountTransferResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAccountTransfer extends ViewRecord
{
    protected static string $resource = AccountTransferResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
