<?php

namespace App\Modules\Base\Traits;

use Str;

trait BootUuidTrait
{
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid(); // Генерируем UUID при создании
        });
    }
}
