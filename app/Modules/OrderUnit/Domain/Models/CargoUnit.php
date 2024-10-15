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

        "pallets_space_id",
        "customer_pallets_space",
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

        ];
    }

    /**
    * Связь с заказом многие ко многим
    * @return BelongsToMany
    */
    public function order_units(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(OrderUnit::class, 'order_unit_cargo_unit', 'cargo_unit_id' , 'order_unit_id')->withPivot('factor');
    }


}
