<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\PersonalArea;

readonly class UserManagerCreateDTO
{

    public function __construct(

        public UserVO $userVO,
        public PersonalArea $personalArea, //личный кабинет
        public Organization $organization,
        public TypeCabinetEnum $type_cabinet,

    ) { }

    public static function make(

        UserVO $userVO,
        PersonalArea $personalArea,
        Organization $organization,
        TypeCabinetEnum $type_cabinet


    ) : self {

        return new self(
            userVO: $userVO,
            personalArea: $personalArea,
            organization: $organization,
            type_cabinet: $type_cabinet,
        );

    }
}
