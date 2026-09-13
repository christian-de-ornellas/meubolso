<?php

namespace App\Notifications;

use App\Models\Budget;
use Illuminate\Notifications\Notification;

class BudgetExceededNotification extends Notification
{
    public function __construct(
        protected Budget $budget
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
        return \Filament\Notifications\Notification::make()
            ->title('Orçamento Excedido')
            ->body("O orçamento da categoria \"{$this->budget->category?->name ?? 'Sem categoria'}\" foi excedido. Gasto: {$this->budget->percentage_used}%.")
            ->icon('heroicon-o-exclamation-circle')
            ->danger()
            ->getDatabaseMessage();
    }
}
