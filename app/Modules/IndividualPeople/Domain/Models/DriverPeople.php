<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use App\Modules\IndividualPeople\Domain\Factories\DriverPeopleFactory;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

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
        'organization_id',
        "series",
        "number",
        "date_get",

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

    public function transport() : HasOne
    {
        return $this->hasOne(Transport::class ,'driver_id');
    }

    public function individual_people(): MorphOne
    {
        return $this->morphOne(IndividualPeople::class, 'individualable');
    }
}
