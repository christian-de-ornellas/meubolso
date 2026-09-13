<?php

namespace App\Notifications;

use App\Models\FixedExpense;
use Illuminate\Notifications\Notification;

class ExpiringFixedExpenseNotification extends Notification
{
    public function __construct(
        protected FixedExpense $expense
    ) {}

    public function setId(string $id): static
    {
        $this->id = $id;
        return $this;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        if (! $this->expense->end_date) {
            return [];
        }

        $daysLeft = now()->diffInDays($this->expense->end_date);

        return \Filament\Notifications\Notification::make()
            ->title('Despesa Fixa Expirando')
            ->body("A despesa \"{$this->expense->description}\" vence em {$daysLeft} dias ({$this->expense->end_date->format('d/m/Y')}).")
            ->icon('heroicon-o-clock')
            ->warning()
            ->getDatabaseMessage();
    }
}
