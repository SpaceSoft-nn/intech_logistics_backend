<?php

namespace App\Modules\Base\Casts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

//При установки времени - мы устанавливаем для бд в формате 'Y-m-d', при получении мы в возвращаем в ру формате 'd.m.Y'
class RuDateTimeCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $date = Carbon::parse($value);

        return $date->format('d.m.Y');
    }


    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        $date = Carbon::createFromFormat('d.m.Y', $value);
        return $date->format('Y.m.d');
    }
}
