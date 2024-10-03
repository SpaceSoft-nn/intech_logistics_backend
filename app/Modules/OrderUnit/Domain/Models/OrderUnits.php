<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\OrderUnitFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderUnits extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'order_units';

    protected function newFactory()
    {
        return OrderUnitFactory::new();
    }

    protected $fillable = [

        "delivery_start",
        "delivery_end",
        "adress_start_id",
        "adresses",
        "adress_end_id",
        "adresses",
        "body_volume",
        "order_total",
        "description",
        "product_type",
        "order_status",
        "user_id",
        "organization_id",
        "mgx_id",
        "body_volume",

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
}
