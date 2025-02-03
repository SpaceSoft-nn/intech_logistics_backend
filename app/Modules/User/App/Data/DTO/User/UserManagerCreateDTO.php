<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;

readonly class UserManagerCreateDTO
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
