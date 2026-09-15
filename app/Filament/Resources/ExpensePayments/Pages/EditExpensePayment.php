<?php

namespace App\Filament\Resources\ExpensePayments\Pages;

use App\Filament\Resources\ExpensePayments\ExpensePaymentResource;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditExpensePayment extends EditRecord
{
    protected static string $resource = ExpensePaymentResource::class;

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
