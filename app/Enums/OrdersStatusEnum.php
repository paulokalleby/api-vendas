<?php

namespace App\Enums;

enum OrdersStatusEnum: string
{
    case OPEN     = 'Open';
    case PAID     = 'Paid';
    case CANCELED = 'Canceled';

    public static function toArray(): array
    {
        return [
            self::OPEN     => 'Open',
            self::PAID     => 'Paid',
            self::CANCELED => 'Canceled',
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::OPEN     => 'Aberto',
            self::PAID     => 'Pago',
            self::CANCELED => 'Cancelado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::OPEN     => 'success',
            self::PAID     => 'secondary',
            self::CANCELED => 'danger',
        };
    }
}
