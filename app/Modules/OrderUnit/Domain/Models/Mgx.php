<?php

namespace App\Modules\OrderUnit\Domain\Models;

use App\Modules\OrderUnit\Domain\Factories\MgxFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        "order_unit_id",

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

    public function order_unit(): HasOne
    {
        return $this->hasOne(OrderUnit::class);
    }
}
