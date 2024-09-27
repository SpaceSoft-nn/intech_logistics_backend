<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class IndividualPeople extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organizations';

    protected $fillable = [

        'first_name',
        'last_name',
        'father_name',

        'position',
        'type',

        'other_contact',
        'comment',

        'phone',
        'email',

        'remuved',

        'personal_area_id',
    ];


    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
        'remuved',
    ];

    protected function casts(): array
    {
        return [
            'remuved' => 'boolean',
        ];
    }
}
