<?php

namespace App\Modules\Organization\App\Data\DTO;

use App\Modules\Base\Traits\FilterArrayTrait;
use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\User\Domain\Models\User;
use Illuminate\Contracts\Support\Arrayable;

class OrganizationCreateDTO extends BaseDTO implements Arrayable
{

    use FilterArrayTrait;

    public function __construct(

        public readonly OrganizationVO $organizationVO,
        public readonly User $user,
        public readonly TypeCabinetEnum $type_cabinet,

    ) { }

    public static function make(
        OrganizationVO $organizationVO,
        User $user,
        TypeCabinetEnum $type_cabinet,
    ) : self {

        return new self(
            organizationVO : $organizationVO,
            user : $user,
            type_cabinet : $type_cabinet,
        );
    }

    public function toArray(): array
    {
        //Только сделано для org VO !!
        return $this->organizationVO->toArray();
    }

}
