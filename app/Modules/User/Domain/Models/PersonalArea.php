<?php

namespace App\Modules\User\Domain\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 *
 * @property string $id
 * @property string $owner_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalArea whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PersonalArea extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'personal_areas';

    protected $fillable = [

        'owner_id',

    ];

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [

    ];

    protected function casts(): array
    {
        return [

        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_personal_area');
    }
}
