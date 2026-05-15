<?php

namespace App\Enums;

enum RoleEnum: string
{
    case ADMIN = 'admin';
    case ORGANIZER = 'organizer';
    case USER = 'user';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Admin',
            self::ORGANIZER => 'Organizer',
            self::USER => 'User',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::ADMIN => 'danger',
            self::ORGANIZER => 'warning',
            self::USER => 'primary',
        };
    }

    public static function labels(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [$case->value => $case->label()])->toArray();
    }
}