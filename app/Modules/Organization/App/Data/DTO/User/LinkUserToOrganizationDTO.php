<?php

namespace App\Modules\Organization\App\Data\DTO\User;

use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\Domain\Models\User;

class LinkUserToOrganizationDTO extends BaseDTO
{

    public function __construct(
        public readonly User $user,
        public readonly Organization $organization,
        public readonly TypeCabinetEnum $type_cabinet,
    ) { }

    public static function make(

        User $user,
        Organization $organization,
        TypeCabinetEnum $type_cabinet,

    ) : self {

        return new self(
            user: $user,
            organization: $organization,
            type_cabinet: $type_cabinet,
        );

    }

}
