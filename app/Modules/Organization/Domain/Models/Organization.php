<?php

namespace App\Modules\Organization\Domain\Models;

use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Organization extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'organizations';

    protected $fillable = [

        'owner_id',

        'name',
        'address',
        'website',
        'description',
        'industry',
        'founded_date',

        'phone_number',
        'email',

        'remuved',
        'type',

        'inn',
        'kpp',
        'registration_number',
        'registration_number_individual',

    ];


    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => OrganizationEnum::class,
            'founded_date' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
