<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use App\Modules\IndividualPeople\Domain\Factories\StorekeeperPeopleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StorekeeperPeople extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return StorekeeperPeopleFactory::new();
    }

    protected $table = 'storekeeper_peoples';

    protected $fillable = [

        'personal_area_id',
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

    public function individual_people(): MorphOne
    {
        return $this->morphOne(IndividualPeople::class, 'individualable');
    }

}
