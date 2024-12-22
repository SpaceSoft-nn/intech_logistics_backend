<?php

namespace App\Modules\OrderUnit\Domain\Models\Status;

use App\Modules\OrderUnit\App\Data\Enums\StatusOrderUnitEnum;
use App\Modules\OrderUnit\Domain\Factories\ChainTransportationStatusFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChainTransportationStatus extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'chain_tranportation_statuses';

    protected static function newFactory()
    {
        return ChainTransportationStatusFactory::new();
    }

    protected $fillable = [

        'order_unit_id',
        'from_status_id',
        'to_status_id',
        'comment',
        'active_status',

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
            'enum_status' => StatusOrderUnitEnum::class,
        ];
    }

    //следующий статус в цепочке
    public function to_status(): BelongsTo
    {
        return $this->belongsTo(EnumTransportationStatus::class, 'to_status', 'id')->withDefault();
    }

}
