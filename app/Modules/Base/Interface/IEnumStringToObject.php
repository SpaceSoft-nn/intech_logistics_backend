<?php

namespace App\Modules\Base\Interface;

interface IEnumStringToObject
{
    public static function stringByCaseToObject(?string $value) : self;
}
