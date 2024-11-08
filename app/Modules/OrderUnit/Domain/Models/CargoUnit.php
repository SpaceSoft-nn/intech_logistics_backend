<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\CargoUnitFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CargoUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cargo_units';

    protected static function newFactory()
    {
        return CargoUnitFactory::new();
    }

    protected $fillable = [

        "pallets_space",
        "customer_pallets_space",

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


    /**
 * Связь паллетов с грузами
    * @return BelongsToMany
    */
    public function cargo_goods(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoGood::class, 'cargo_good_cargo_unit', 'cargo_unit_id' , 'cargo_good_id')->withPivot('factor');
    }


}
