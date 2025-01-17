<?php
namespace App\Modules\InteractorModules\Registration\App\Data\DTO;

use App\Modules\InteractorModules\Registration\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;

class CreateRegisterAllDTO extends BaseDTO
{

    public function __construct(
        public RegistrationDTO $registrationDTO,
        public OrganizationVO $organizationVO,
        public readonly TypeCabinetEnum $type_cabinet,
    ) { }

    public static function make(

        registrationDTO $registrationDTO,
        OrganizationVO $organizationVO,
        TypeCabinetEnum $type_cabinet

    ) : self {

        return new self(
            registrationDTO: $registrationDTO,
            organizationVO: $organizationVO,
            type_cabinet: $type_cabinet,
        );

    }

}
