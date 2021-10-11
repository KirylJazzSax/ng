<?php

namespace App\Entity\User;

class Role
{
    public static function guest(): string
    {
        return 'guest';
    }

    public static function user(): string
    {
        return 'user';
    }
}
