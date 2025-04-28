<?php

namespace App\Modules\OrderUnit\Domain\Models\Status;

use Illuminate\Database\Eloquent\Model;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\OrderUnit\Domain\Factories\TransporationStatusFactory;

class TransporationStatus extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transporation_status_events';

    protected  static function newFactory()
    {
        return TransporationStatusFactory::new();
    }

    protected $fillable = [

        "order_unit_id",
        "enum_transporatrion_status_id",

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

        ];
    }

    public function enum_transporatrion_status() : BelongsTo
    {
        return $this->belongsTo(EnumTransportationStatus::class, 'enum_transporatrion_status_id', 'id');
    }

    public function order_unit() : BelongsTo
    {
        return $this->belongsTo(OrderUnit::class, 'order_unit_id', 'id');
    }

}
