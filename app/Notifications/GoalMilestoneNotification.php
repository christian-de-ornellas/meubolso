<?php

namespace App\Notifications;

use App\Models\FinancialGoal;
use Illuminate\Notifications\Notification;

class GoalMilestoneNotification extends Notification
{
    public function __construct(
        protected FinancialGoal $goal,
        protected int $milestone
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
        $icon = $this->milestone === 100 ? 'heroicon-o-trophy' : 'heroicon-o-flag';
        $color = $this->milestone === 100 ? 'success' : 'info';
        $title = $this->milestone === 100 ? 'Meta Atingida!' : "Meta {$this->milestone}% Alcançada";

        return \Filament\Notifications\Notification::make()
            ->title($title)
            ->body("A meta \"{$this->goal->name}\" atingiu {$this->milestone}% do objetivo.")
            ->icon($icon)
            ->{$color}()
            ->getDatabaseMessage();
    }
}
