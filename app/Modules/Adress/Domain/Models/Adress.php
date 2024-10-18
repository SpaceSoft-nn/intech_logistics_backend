<?php

namespace App\Modules\Adress\Domain\Models;

use App\Modules\Adress\App\Data\Enums\TypeAdressEnum;
use App\Modules\Adress\Domain\Factories\AdressFactory;
use App\Modules\InteractorModules\AdressOrder\Domain\Models\OrderUnitAddress;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Adress extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return AdressFactory::new();
    }

    protected $table = 'adresses';

    protected $fillable = [

        "region",
        "city",
        "street",
        "building",
        "apartment",
        "house_number",
        "postal_code",
        "latitude",
        "longitude",
        "type_adress",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "type_adress" => TypeAdressEnum::class,
            "latitude" => "decimal:10",
            "longitude" => "decimal:10",
        ];
    }

    public function order_units(): BelongsToMany
    {
        return $this->belongsToMany(OrderUnit::class, 'order_unit_adress', 'adress_id' , 'order_unit_id')
            ->using(OrderUnitAddress::class)
            ->withPivot(['data_time', 'type', 'priority'])
            ->withTimestamps();
    }


}
