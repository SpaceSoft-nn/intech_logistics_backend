<?php

namespace App\Modules\InteractorModules\Registration\Domain\Interactor;

use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistratiorUserManagerDTO;
use Exception;
use function App\Helpers\Mylog;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\Domain\Services\UserService;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;

use App\Modules\Organization\App\Repositories\OrganizationRepository;

// Бизнес логика для создание заказа, когда заказ создатёся от Тендера
class RegistrationUserManagerInteractor
{

    public function __construct(
        private OrganizationRepository $orgRep,
        private UserRepository $userRep,
        private UserService $userService,
    ) { }


    public function execute(RegistratiorUserManagerDTO $dto)
    {
        return $this->run($dto);
    }


    private function run(RegistratiorUserManagerDTO $dto) : User
    {
        /** @var Organization */
        $organization = $dto->organization;

        /** @var User */
        $owner = User::find($organization->owner_id);

        $personal_area = $this->userRep->isOwnerPersonalArea($owner);

        if(is_null($personal_area)) {
            //Делаем навсякий-случай проверку
            Mylog('Ошибка в UserManagerCreateInteractor, personal_area - не был найден');
            throw new Exception(code: 500);
        }

        //устанавливаем роль менеджера и что он будет не активен
        /** @var UserVO */
        $userVO = $dto->userVO->setRole(UserRoleEnum::manager)->setActiveUser(false);

        $user = $this->userService->createUserManager(
            UserManagerCreateDTO::make(
                userVO: $userVO,
                personalArea: $personal_area,
            )
        );

        return $user;

    }

}
