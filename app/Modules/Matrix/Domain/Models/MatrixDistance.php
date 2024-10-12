<?php

namespace App\Modules\Matrix\Domain\Models;

use App\Modules\Matrix\Domain\Factories\MatrixDistanceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatrixDistance extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return MatrixDistanceFactory::new();
    }

    protected $table = 'matrix_distance';

    protected $fillable = [

        'city_start_gar_id',
        'city_end_gar_id',

        'city_name_start',
        'city_name_end',

        'factor',

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
