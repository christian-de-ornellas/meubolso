<?php

namespace App\Enums;

enum BillingCycle: string
{
    case Monthly = 'monthly';
    case Yearly = 'yearly';
    case Weekly = 'weekly';

    public function label(): string
    {
        return match ($this) {
            self::Monthly => 'Mensal',
            self::Yearly => 'Anual',
            self::Weekly => 'Semanal',
        };
    }
}
