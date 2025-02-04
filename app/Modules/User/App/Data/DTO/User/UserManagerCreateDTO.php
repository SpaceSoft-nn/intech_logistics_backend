<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\PersonalArea;

readonly class UserManagerCreateDTO
{

    public function __construct(

        public UserVO $userVO,
        public PersonalArea $personalArea, //кабинет


    ) { }

    public static function make(

        UserVO $userVO,
        PersonalArea $personalArea,


    ) : self {

        return new self(
            userVO: $userVO,
            personalArea: $personalArea,
        );

    }
}
