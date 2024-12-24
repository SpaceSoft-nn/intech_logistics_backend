<?php

namespace App\Modules\IndividualPeople\Domain\Models;

use App\Modules\IndividualPeople\Domain\Factories\IndividualPeopleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 *
 *
 * @property string $id
 * @property string|null $owner_id
 * @property string $name
 * @property string $address
 * @property string|null $phone_number
 * @property string|null $email
 * @property bool $remuved Статус Закрыт/Открыт
 * @property string|null $website
 * @property string $type
 * @property string|null $description
 * @property string|null $okved
 * @property string|null $founded_date
 * @property string $inn Инн у ООО/ИП
 * @property string|null $kpp КПП - Только у организации
 * @property string|null $registration_number ОГРН - Только у организации
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople query()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFoundedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereokved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereInn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereKpp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRegistrationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRegistrationNumberIndividual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereRemuved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereWebsite($value)
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $father_name Отчество
 * @property string $position
 * @property string $phone
 * @property string $other_contact
 * @property string $comment
 * @property string $personal_area_id
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople whereOtherContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualPeople wherePosition($value)
 * @mixin \Eloquent
 */
class IndividualPeople extends Model
{
    use HasFactory, HasUuids;

    protected static function newFactory()
    {
        return IndividualPeopleFactory::new();
    }

    protected $table = 'individual_peoples';

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

    public function driverPeople()
    {
        return $this->hasOne(DriverPeople::class, 'individual_people_id');
    }
}
