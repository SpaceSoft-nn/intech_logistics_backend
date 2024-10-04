<?php

namespace App\Modules\Transfer\Domain\Models;

use App\Modules\Transfer\Domain\Factories\TransferFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transfers';

    protected static function newFactory()
    {
        return TransferFactory::new();
    }

    protected $fillable = [

        "transport_id",
        "delivery_start",
        "delivery_end",
        "adress_start_id",
        "adress_end_id",
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
