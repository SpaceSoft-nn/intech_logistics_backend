<?php

namespace App\Modules\Transport\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Base\Casts\RuDateTimeCast;
use App\Modules\Address\Domain\Models\Address;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\OrderUnit\Domain\Models\Status\EnumTransportationStatus;

class TransportationStatusСalendar extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transportation_status_calendars';

    // protected  static function newFactory()
    // {
    //     return TransporationStatusFactory::new();
    // }

    protected $fillable = [

        "order_unit_id",
        "enum_transportation_id",
        "date",
        "transport_id",
        "address_id",

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
            "date" => RuDateTimeCast::class,
        ];
    }

    public function order() : BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_unit_id', 'id');
    }

    public function enumTransportation() : BelongsTo
    {
        return $this->belongsTo(EnumTransportationStatus::class, 'enum_transportation_id', 'id');
    }

    public function transport() : BelongsTo
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'id');
    }

    public function address() : BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id', 'id');
    }

}
