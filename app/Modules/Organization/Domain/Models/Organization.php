<?php

namespace App\Modules\Organization\Domain\Models;

use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Factories\OrganizationFactory;
use App\Modules\Transport\Domain\Models\Transport;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Mailer\Transport\Transports;

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
 * @property string|null $okved
 * @property \Illuminate\Support\Carbon|null $founded_date
 * @property string $inn Инн у ООО/ИП
 * @property string|null $kpp КПП - Только у организации
 * @property string|null $registration_number ОГРН - Только у организации
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
 * @method static \Illuminate\Database\Eloquent\Builder|Organization whereokved($value)
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

    protected static function newFactory()
    {
        return OrganizationFactory::new();
    }

    protected $fillable = [

        'owner_id',

        'name',
        'address',
        'website',
        'description',
        'okved',
        'founded_date',

        'phone',
        'email',
        'remuved',
        'type',

        'inn',
        'kpp',
        'registration_number',

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

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_organization', 'organization_id', 'user_id')->withPivot('type_cabinet');
    }

    public function order_units() : HasMany
    {
        return $this->hasMany(OrderUnit::class, 'organization_id', 'id');
    }

    public function transports() : HasMany
    {
        return $this->hasMany(Transport::class, 'organization_id', 'id');
    }

    public function drivers() : HasMany
    {
        return $this->hasMany(DriverPeople::class, 'organization_id', 'id');
    }


}
