<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use App\Modules\IndividualPeople\Domain\Factories\DriverPeopleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class DriverPeople extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return DriverPeopleFactory::new();
    }

    protected $table = 'driver_peoples';

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

    protected function casts(): array
    {
        return [

        ];
    }
}
