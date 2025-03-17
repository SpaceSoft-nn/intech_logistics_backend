<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use App\Modules\IndividualPeople\Domain\Factories\PassportFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Passport extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return PassportFactory::new();
    }

    protected $table = 'passports';

    protected $fillable = [


        "first_name",
        "last_name",
        "father_name",

        "passport_series",
        "passport_number",

        "issue_date",
        "issued_by",

        "department_code",
        "individual_people_id",

        "birth_day",

    ];


    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => \App\Modules\Base\Casts\RuDateTimeCast::class,
            'birth_day' => \App\Modules\Base\Casts\RuDateTimeCast::class,
        ];
    }

    public function individualPeople(): BelongsTo
    {
        return $this->belongsTo(IndividualPeople::class, 'individual_people_id', 'id');
    }

}
