<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\App\Data\Enums\PalletType\TypeSizePalletSpaceEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CargoGood extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cargo_goods';

    // protected static function newFactory()
    // {
    //     return CargoUnitFactory::new();
    // }

    protected $fillable = [

        "name_value",
        "product_type",

        "type_pallet",

        "cargo_units_count",
        "body_volume",

        "description",

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
            "type_pallet" => TypeSizePalletSpaceEnum::class,
        ];
    }

    /**
    * Связь c cargo_unit (паллетами)
    * @return BelongsToMany
    */
    public function cargo_units(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoUnit::class, 'cargo_good_cargo_unit', 'cargo_good_id' , 'cargo_unit_id')
                    ->using(CargoUnitCargoGood::class)
                    ->withPivot('factor')
                    ->withTimestamps();
    }

    /**
    * Связь с заказом многие ко многим
    * @return BelongsToMany
    */
    public function order_units(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoUnit::class, 'order_unit_cargo_good', 'cargo_good_id' , 'order_unit_id');
    }


    public function mgx(): HasOne
    {
        return $this->hasOne(Mgx::class);
    }

}
