<?php

namespace App\Modules\InteractorModules\Registration\App\Data\DTO;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;

readonly class RegistratiorUserManagerDTO
{

    public function __construct(

        public Organization $organization,
        public UserVO $userVO,

    ) { }

    public static function make(

        Organization $organization,
        UserVO $userVO,

    ) : self {

        return new self(
            organization: $organization,
            userVO: $userVO,
        );

    }
}
