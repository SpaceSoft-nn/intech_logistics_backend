<?php

namespace App\Modules\Transport\Domain\Models;

use App\Modules\Transport\App\Data\Enums\TransportStatusEnum;
use App\Modules\Transport\Domain\Factories\TransportFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{

    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return TransportFactory::new();
    }

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
        'description'

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "type_status" => TransportStatusEnum::class,
        ];
    }


}
