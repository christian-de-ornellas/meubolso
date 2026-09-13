<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Notifications\Notification;

class UpcomingSubscriptionNotification extends Notification
{
    protected ?string $customId = null;

    public function __construct(
        protected Subscription $subscription
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
        return \Filament\Notifications\Notification::make()
            ->title('Cobrança de Assinatura')
            ->body("A assinatura \"{$this->subscription->name}\" será cobrada em {$this->subscription->next_billing_date->format('d/m/Y')} (R$ " . number_format($this->subscription->amount, 2, ',', '.') . ").")
            ->icon('heroicon-o-arrow-path')
            ->info()
            ->getDatabaseMessage();
    }
}
