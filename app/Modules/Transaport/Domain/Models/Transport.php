<?php

namespace App\Modules\Transaport\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'transports';

    protected $fillable = [

        "type",
        "brand_model",
        "year",
        "transport_number",
        "body_volume",
        "body_weight",
        "type_status",
        "organization_id",
        "driver_id",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [

        ];
    }


}
