<?php

namespace App\Modules\Matrix\Domain\Models;

use App\Modules\Matrix\Domain\Factories\RegionEconomicFactorFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionEconomicFactors extends Model
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
