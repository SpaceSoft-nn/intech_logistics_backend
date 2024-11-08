<?php

namespace App\Modules\OrderUnit\Domain\Models;


use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

        "cargo_units_count",
        "body_bolume",

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
    * Связь c cargo_unit (паллетами)
    * @return BelongsToMany
    */
    public function cargo_units(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoUnit::class, 'cargo_good_cargo_unit', 'cargo_good_id' , 'cargo_unit_id')->withPivot('factor');
    }

    /**
    * Связь с заказом многие ко многим
    * @return BelongsToMany
    */
    public function order_units(): BelongsToMany
    {
        //TODO Может быть баг - потом проверить
        return $this->belongsToMany(CargoUnit::class, 'order_unit_cargo_good', 'cargo_good_id' , 'order_unit_id')->withPivot('factor');
    }

    public function mgx(): BelongsTo
    {
        return $this->belongsTo(Mgx::class);
    }

}
