<?php

namespace App\Modules\Address\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Address\App\Data\Enums\TypeAddressEnum;
use App\Modules\Address\Domain\Factories\AddressFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Modules\InteractorModules\AddressOrder\Domain\Models\OrderUnitAddress;

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
        "postal_code",
        "latitude",
        "longitude",
        'json',
        'update_json',
        'nomination',
        'point_name',

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
            "json" => "array",
        ];
    }

    public function order_units(): BelongsToMany
    {
        return $this->belongsToMany(OrderUnit::class, 'order_unit_address', 'address_id' , 'order_unit_id')
            ->using(OrderUnitAddress::class)
            ->withPivot(['data_time', 'type', 'priority'])
            ->withTimestamps();
    }


}
