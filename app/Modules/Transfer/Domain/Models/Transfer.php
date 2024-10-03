<?php

namespace App\Modules\Transfer\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    use HasFactory, HasUuids;

    protected $table = 'transfers';

    protected $fillable = [

        "transport_id",
        "transports",
        "delivery_start",
        "delivery_end",
        "adress_start_id",
        "adresses",
        "adress_end_id",
        "adresses",
        "order_total",
        "description",
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
