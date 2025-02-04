<?php

namespace App\Modules\InteractorModules\Registration\Domain\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserOrganization extends Model
{
    use HasFactory;

    // protected static function newFactory()
    // {
    //     return PersonalAreaFactory::new();
    // }

    protected $table = 'user_organization';

    protected $fillable = [

        'user_id',
        'organization_id',
        'type_cabinet',

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
            'type_cabinet' => TypeCabinetEnum::class,
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function organization() : BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }


}
