<?php

namespace App\Enums;

enum AccountType: string
{
    case Checking = 'checking';
    case Savings = 'savings';
    case Wallet = 'wallet';
    case Investment = 'investment';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Checking => 'Conta Corrente',
            self::Savings => 'Poupança',
            self::Wallet => 'Carteira',
            self::Investment => 'Investimento',
            self::Other => 'Outro',
        };
    }
}
