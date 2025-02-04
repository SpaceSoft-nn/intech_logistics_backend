<?php

namespace App\Modules\InteractorModules\Registration\App\Data\DTO;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;

readonly class RegistratiorUserManagerDTO
{

    public function __construct(

        public Organization $organization,
        public UserVO $userVO,
        public ?string $phone_id, //phone для проверки подтвреждения и установки юзеру
        public readonly ?string $email_id, //email для проверки подтвреждения и установки юзеру

    ) { }

    public static function make(

        Organization $organization,
        UserVO $userVO,
        ?string $phone_id = null,
        ?string $email_id = null,

    ) : self {

        return new self(
            organization: $organization,
            userVO: $userVO,
            phone_id: $phone_id,
            email_id: $email_id,
        );

    }
}
