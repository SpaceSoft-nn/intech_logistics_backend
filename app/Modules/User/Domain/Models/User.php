<?php

namespace App\Modules\User\Domain\Models;

use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property string $id
 * @property mixed $password
 * @property string $first_name Имя
 * @property string $last_name Фамилия
 * @property string $father_name Отчество
 * @property UserRoleEnum $role Роль User
 * @property int $access_type Тип доступа
 * @property bool $active Активен ли пользователь
 * @property bool $auth Прошёл ли пользователь нотификацию
 * @property string|null $personal_area_id
 * @property string|null $email_id
 * @property string|null $phone_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remember_token
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAccessType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFatherName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePersonalAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use HasFactory, HasUuids, HasApiTokens, Notifiable;

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    protected $table = 'users';

    protected $fillable = [

        'first_name',
        'last_name',
        'father_name',
        'password',

        'role',
        'permission',

        'active',
        'auth',

        'personal_area_id',
        'email_id',
        'phone_id',

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'access_type',
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'role' => UserRoleEnum::class,
            'password' => 'hashed',
        ];
    }


    public function personal_areas(): BelongsToMany
    {
        return $this->belongsToMany(PersonalArea::class, 'user_personal_area', 'user_id' , 'personal_area_id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class, 'user_organization', 'user_id' , 'organization_id')->withPivot('type_cabinet');
    }

    public function phone(): BelongsTo
    {
        return $this->belongsTo(PhoneList::class);
    }

    public function email(): BelongsTo
    {
        return $this->belongsTo(EmailList::class);
    }
}
