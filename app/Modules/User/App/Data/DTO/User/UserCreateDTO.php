<?php

namespace App\Modules\User\App\Data\DTO\User;

use App\Modules\User\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;

class UserCreateDTO extends BaseDTO
{

    public function __construct(
        public readonly UserVO $userVO,
        public readonly ?User $userAuth,
    ) { }

    public static function make(UserVO $userVO, ?User $userAuth = null) : self
    {
        return new self(
            userVO: $userVO,
            userAuth: $userAuth,
        );
    }

    public function setUserVO($userVO)
    {
        return self::make(
            userVO: $userVO,
            userAuth: $this->userAuth
        );
    }
}
