<?php

namespace App\Modules\Matrix\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Base\Casts\RuDateTimeCast;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\OrderUnit\App\Data\Enums\TypeLoadingTruckMethod;
use App\Modules\Matrix\Domain\Factories\RegionEconomicFactorFactory;

class RegionEconomicFactor extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return RegionEconomicFactorFactory::new();
    }

    protected $table = 'region_economic_factors';

    protected $fillable = [

        'region_start_gar_id',
        'region_end_gar_id',

        'region_name_start',
        'region_name_end',

        'factor',
        'price',

        'type',
        'start_date',
        'end_date',

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

            'type' => TypeLoadingTruckMethod::class,
            'start_date' => RuDateTimeCast::class,
            'end_date' => RuDateTimeCast::class,

        ];
    }
}
