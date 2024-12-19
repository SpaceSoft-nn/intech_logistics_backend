<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//P.S Event просто название что это событие статуса: в пути, на разгрузке и т.д
class StatusTransportationEventModel extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transportating_event_orders';

    //Это делается для более точного получение последней записи (если запись получается в запросе по времени)
    //P.S Может быть баг с сервером, может быть разное серверное время, если база разбивается на несколько сервесов
    protected $dateFormat = 'Y-m-d H:i:s.u';

    // protected static function newFactory()
    // {
    //     return OrderUnitFactory::new();
    // }

    protected $fillable = [

        'order_unit_id',
        'status',

    ];

    protected $guarded = [

        'id',
        'created_at',
        'updated_at',

    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [
            'status' => StatusOrderUnitEnum::class,
        ];
    }

    public function order_unit(): BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_unit_id');
    }

}
