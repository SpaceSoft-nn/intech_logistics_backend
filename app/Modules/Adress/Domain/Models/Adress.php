<?php

namespace App\Modules\Adress\Domain\Models;

use App\Modules\Adress\App\Data\Enums\TypeAdressEnum;
use App\Modules\Adress\Domain\Factories\AdressFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
