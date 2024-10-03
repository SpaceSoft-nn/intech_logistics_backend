<?php

namespace App\Modules\Adress\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adress extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'adresses';

    protected $fillable = [

        "region",
        "city",
        "street",
        "building",
        "apartment",
        "house_number",
        "postal_code",
        "coordinates",
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

        ];
    }
}
