<?php

namespace App\Modules\OrderUnit\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargoUnit extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'cargo_units';

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
}
