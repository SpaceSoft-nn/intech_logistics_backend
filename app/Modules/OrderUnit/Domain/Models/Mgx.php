<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\MgxFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mgx extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'mgxs';

    protected  static function newFactory()
    {
        return MgxFactory::new();
    }

    protected $fillable = [

        "length",
        "width",
        "height",
        "weight",
        "cargo_good_id",

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

    public function cargo_good(): BelongsTo
    {
        return $this->belongsTo(CargoGood::class);
    }
}
