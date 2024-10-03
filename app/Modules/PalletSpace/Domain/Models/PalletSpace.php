<?php

namespace App\Modules\PalletSpace\Domain\Models;

use App\Modules\PalletSpace\App\Data\Enums\TypeMaterialPalletSpaceEnum;
use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;
use App\Modules\PalletSpace\Domain\Factories\PalletSpaceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PalletSpace extends Model
{

    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PalletSpaceFactory::new();
    }

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
            'type_material' => TypeMaterialPalletSpaceEnum::class,
            'type_size' => TypeSizePalletSpaceEnum::class,
        ];
    }
}
