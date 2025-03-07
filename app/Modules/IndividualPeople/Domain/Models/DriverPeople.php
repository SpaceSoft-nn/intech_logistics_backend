<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Transport\Domain\Models\Transport;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\IndividualPeople\Domain\Factories\DriverPeopleFactory;

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
           "date_get" => \App\Modules\Base\Casts\RuDateTimeCast::class
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

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }
}
