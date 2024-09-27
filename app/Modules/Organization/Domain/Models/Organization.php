<?php

namespace App\Modules\Organization\Domain\Models;

use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 *
 * @property string $id
 * @property string|null $owner_id
 * @property string $name
 * @property string $address
 * @property string|null $phone_number
 * @property string|null $email
 * @property bool $remuved Статус Закрыт/Открыт
 * @property string|null $website
 * @property OrganizationEnum $type
 * @property string|null $description
 * @property string|null $industry
 * @property \Illuminate\Support\Carbon|null $founded_date
 * @property string $inn Инн у ООО/ИП
 * @property string|null $kpp КПП - Только у организации
 * @property string|null $registration_number ОГРН - Только у организации
 * @property string|null $registration_number_individual ОГРНИП - Только у ИП
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereFoundedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereIndustry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRegistrationNumberIndividual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereRemuved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereWebsite($value)
 * @mixin \Eloquent
 */
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

        'phone',
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
        ];
    }
}
