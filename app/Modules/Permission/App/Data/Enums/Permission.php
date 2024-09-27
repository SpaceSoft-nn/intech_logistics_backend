<?php

namespace App\Modules\Permission\App\Data\Enums;

use Exception;
use PhpParser\Node\Expr\Throw_;

enum Permission : int
{
    case SELECT = 8;   // 2^3 = 1000 в двоичном представлении
    case CREATE = 4;   // 2^2 = 0100 в двоичном представлении
    case UPDATE = 2;   // 2^1 = 0010 в двоичном представлении
    case DELETE = 1;   // 2^0 = 0001 в двоичном представлении

    public static function getPermissionsFromValue(int $value): array
    {
        $permissions = [];

        if ($value & self::SELECT->value) {
            $permissions[] = 'SELECT';
        }
        if ($value & self::CREATE->value) {
            $permissions[] = 'CREATE';
        }
        if ($value & self::UPDATE->value) {
            $permissions[] = 'UPDATE';
        }
        if ($value & self::DELETE->value) {
            $permissions[] = 'DELETE';
        }

        return $permissions;
    }

    public static function accessByValue(int $value, Permission $enum) : bool
    {
        return $value & $enum->value ? true : false;
    }

    public static function accessByAll(int $value){

        if ( !($value & self::SELECT->value) ) {
            return false;
        }
        else if ( !($value & self::CREATE->value) ) {
            return false;
        }
        else if ( !($value & self::UPDATE->value) ) {
            return false;
        }
        else if ( !($value & self::DELETE->value) ) {
            return false;
        }

        return true;
    }

    /**
     * Получить роль user и вернуть десятичное представление прав
     * @param string $value
     *
     * @return int
     */
    public static function permissionByRole(string $value) : int
    {

        return match ($value)
        {
            'admin' => 15,
            'manager' => 12,
            'observed' => 8,
            default => throw new Exception('Неизвестная роль User', 500),
        };

    }

}
