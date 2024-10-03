<?php

namespace App\Modules\PalletSpace\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletSpace extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'pallets_space';

    protected $fillable = [

        "type_material",
        "type_size",
        "size",
        "witght",
        "max_witght",
        "uuid_out",
        "manufacture",
        "description",

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
