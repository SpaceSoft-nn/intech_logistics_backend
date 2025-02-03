<?php

namespace App\Modules\InteractorModules\Registration\Domain\Services;

use App\Modules\InteractorModules\Registration\App\Data\DTO\Base\BaseDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\CreateRegisterAllDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistratiorUserManagerDTO;
use App\Modules\InteractorModules\Registration\Domain\Interactor\RegistrationInteractor;
use App\Modules\InteractorModules\Registration\Domain\Interactor\RegistrationUserAndOrganizationInteractor;
use App\Modules\InteractorModules\Registration\Domain\Interactor\RegistrationUserManagerInteractor;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\Domain\Interactor\UserManagerCreateInteractor;
use App\Modules\User\Domain\Models\User;

class RegistrationService
{
    public function __construct(
        private RegistrationInteractor $interatorRegister,
        private RegistrationUserAndOrganizationInteractor $registrationUserAndOrganizationInteractor,
        private RegistrationUserManagerInteractor $registrationUserManagerInteractor,
    ) { }

    /**
     * Проверяет нотифкацию user по email, phone и создаёт User
     * @param RegistrationDTO $dto
     *
     * @return array
     */
    public function registerUser(BaseDTO $dto) : array|User
    {
        return $this->interatorRegister->run($dto);
    }

    /**
    * Логика регистрации User
    * @param CreateRegisterAllDTO $dto
    *
    */
    public function registrationUser(CreateRegisterAllDTO $dto)
    {
        $org = Organization::where('inn', $dto->inn)->first();

        //если $org - не найден по inn, создаём user и организацию, иначе создаём менеджера
        if(is_null($org))
        {
            //Регистрация в 1 endpoint - сразу организации и создание user
            $result = $this->registrationUserAndOrganizationInteractor->run($dto);

            return $result;

        } else {

            /** @var RegistratiorUserManagerDTO */
            $dto = RegistratiorUserManagerDTO::make(
                organization: $org,
                userVO: $dto->registrationDTO->userDTO->userVO,
            );

            //Регистрация manager, в организации
            $result = $this->registrationUserManagerInteractor->execute($dto);

            return $result;

        }
    }


}
