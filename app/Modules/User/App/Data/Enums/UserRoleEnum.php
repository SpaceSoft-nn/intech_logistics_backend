<?php

namespace App\Modules\User\App\Data\Enums;

use Exception;

enum UserRoleEnum : string
{
    case admin = "admin";
    case manager = "manager";
    case observed = "observed";

    public static function returnObjectByString(string $data)
    {
        return match ($data) {
            "admin" => self::admin,
            "manager" =>  self::manager,
            "observed" =>  self::observed,
            "default" =>  null,
        };
    }
}
