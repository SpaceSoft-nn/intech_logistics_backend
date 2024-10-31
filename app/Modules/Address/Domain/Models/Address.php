<?php

namespace App\Modules\Address\Domain\Models;

use App\Modules\Address\App\Data\Enums\TypeAddressEnum;
use App\Modules\Address\Domain\Factories\AddressFactory;
use App\Modules\InteractorModules\AddressOrder\Domain\Models\OrderUnitAddress;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Address extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return AddressFactory::new();
    }

    protected $table = 'addresses';

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
        "type_Address",

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            "type_Address" => TypeAddressEnum::class,
            "latitude" => "decimal:10",
            "longitude" => "decimal:10",
        ];
    }

    public function order_units(): BelongsToMany
    {
        return $this->belongsToMany(OrderUnit::class, 'order_unit_Address', 'Address_id' , 'order_unit_id')
            ->using(OrderUnitAddress::class)
            ->withPivot(['data_time', 'type', 'priority'])
            ->withTimestamps();
    }


}
