<?php
namespace App\Modules\InteractorModules\Registration\App\Data\DTO;

use App\Modules\InteractorModules\Registration\App\Data\DTO\Base\BaseDTO;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;

class RegistrationDTO extends BaseDTO
{

    public function __construct(
        public readonly UserCreateDTO $userDTO,
        public readonly ?string $phone,
        public readonly ?string $email,
    ) { }

    public static function make(UserCreateDTO $userDTO, string $phone = null, string $email = null) : self
    {
        return new self(
            userDTO: $userDTO,
            phone: $phone,
            email: $email,
        );
    }


}
