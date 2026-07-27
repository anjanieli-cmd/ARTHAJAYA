<?php

namespace App\Enums;

enum AccessLevel: string
{
    case Admin = 'admin';
    case Staff = 'staff';
    case User  = 'user';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Staff => 'Staff',
            self::User  => 'User',
        };
    }

    public static function options(): array
    {
        return [
            self::Admin->value => self::Admin->label(),
            self::Staff->value => self::Staff->label(),
            self::User->value  => self::User->label(),
        ];
    }
}