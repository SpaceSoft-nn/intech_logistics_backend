<?php

namespace App\Modules\InteractorModules\AddressOrder\Domain\Models;

use App\Modules\InteractorModules\AddressOrder\App\Data\Enum\TypeStateAddressEnum;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderUnitAddress extends Pivot
{
    public $incrementing = true;

    protected $table = 'order_unit_Address'; // Убедитесь, что название таблицы правильное

    protected $fillable = [
        'order_unit_id',
        'Address_id',
        'data_time',
        'type',
        'priority',
    ];

    // Если вы используете даты, добавьте их в $dates или $casts
    protected $dates = ['data_time', 'created_at', 'updated_at'];

    protected $casts = [
        'type' => TypeStateAddressEnum::class,
        'priority' => 'integer',
    ];

    /**
     * Boot method for the pivot model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pivot) {
            // Установка приоритетности только если приоритет не задан
            if (empty($pivot->priority)) {

                // Получение максимального текущего приоритета для данного order_unit_id
                $maxPriority = self::where('order_unit_id', $pivot->order_unit_id)->max('priority');

                // Установка приоритета как max + 1, если нет записей -- 1
                $pivot->priority = $maxPriority ? $maxPriority + 1 : 1;
            }
        });
    }
}
