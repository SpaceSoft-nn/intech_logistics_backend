<?php

namespace App\Modules\OrderUnit\Domain\Models\Status;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\OrderUnit\App\Data\Enums\TransportationStatusEnum;

class EnumTransportationStatus extends Model
{

    use HasFactory;

    protected $table = 'enum_transportation_statuses';

    // protected static function newFactory()
    // {
    //     return OrderUnitFactory::new();
    // }

    protected $fillable = [

        'enum_name',
        'enum_value',

    ];

    protected $guarded = [

        'id',
        'created_at',
        'updated_at',

    ];

    protected $hidden = [
        'enum_name',
    ];

    protected function casts(): array
    {
        return [
            'enum_value' => TransportationStatusEnum::class,
        ];
    }

}
