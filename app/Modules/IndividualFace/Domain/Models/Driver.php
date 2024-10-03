<?php

namespace App\Modules\IndividualFace\Domain\Models;

use App\Modules\IndividualFace\Domain\Factories\DriverFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return DriverFactory::new();
    }

    protected $table = 'drivers';

    protected $fillable = [

        'personal_area_id',
        'individual_people_id',
        'organization_id',

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
