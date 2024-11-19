<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use App\Modules\OrderUnit\Domain\Factories\CargoUnitFactory;
use App\Modules\Transfer\Domain\Models\Transfer;
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
            'pallets_space' => TypeSizePalletSpaceEnum::class,
        ];
    }


    /**
    * Связь паллетов с грузами
    * @return BelongsToMany
    */
    public function cargo_goods(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoGood::class, 'cargo_good_cargo_unit', 'cargo_unit_id' , 'cargo_good_id')
            ->using(CargoUnitCargoGoodPivot::class)
            ->withPivot('factor')
            ->withTimestamps();
    }

    public function transfers(): BelongsToMany
    {
        return $this->belongsToMany(Transfer::class, 'cargo_unit_transfer', 'cargo_unit_id' , 'transfer_id');
    }

}
