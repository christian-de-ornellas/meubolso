<?php

namespace App\Notifications;

use App\Models\ExpensePayment;
use Illuminate\Notifications\Notification;

class UpcomingPaymentNotification extends Notification
{
    protected ?string $customId = null;

    public function __construct(
        protected ExpensePayment $payment
    ) {}

    public function setId(string $id): static
    {
        $this->customId = $id;
        return $this;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $expense = $this->payment->expense;

        return \Filament\Notifications\Notification::make()
            ->title('Pagamento Pendente')
            ->body("A despesa \"{$expense?->description}\" está pendente para {$this->payment->month_name}/{$this->payment->year}.")
            ->icon('heroicon-o-exclamation-triangle')
            ->warning()
            ->getDatabaseMessage();
    }
}
