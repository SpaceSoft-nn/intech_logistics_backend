<?php

namespace App\Modules\OrderUnit\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mgx extends Model
{

    use HasFactory, HasUuids;

    protected $table = 'mgxs';

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
}
