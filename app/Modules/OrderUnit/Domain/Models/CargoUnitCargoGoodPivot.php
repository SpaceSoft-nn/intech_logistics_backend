<?php

namespace App\Modules\OrderUnit\Domain\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CargoUnitCargoGoodPivot extends Pivot
{

    public $incrementing = true;

    protected $table = 'cargo_good_cargo_unit';


    protected $fillable = [
        "factor",
    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];
}
