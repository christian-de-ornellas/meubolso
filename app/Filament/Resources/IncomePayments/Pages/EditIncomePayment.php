<?php

namespace App\Filament\Resources\IncomePayments\Pages;

use App\Filament\Resources\IncomePayments\IncomePaymentResource;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIncomePayment extends EditRecord
{
    protected static string $resource = IncomePaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            Action::make('dismiss')
                ->label('Remover')
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->requiresConfirmation()
                ->action(function () {
                    $this->record->update(['dismissed' => true]);
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}
