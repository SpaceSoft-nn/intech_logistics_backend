<?php

namespace App\Modules\InteractorModules\Registration\Domain\Interactor;

use App\Modules\InteractorModules\Registration\App\Data\DTO\CreateRegisterAllDTO;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Services\UserService;
use DB;

class RegistrationUserAndOrganizationInteractor
{
    public function __construct(
        public UserService $userService,
        // public NotificationService $NotificationService,
        public OrganizationService $orgService,
    ) {}



    public function run(CreateRegisterAllDTO $dto) : array
    {
        /** @var array */
        $array = DB::transaction(function () use ($dto) {

            /**
            * @var UserCreateDTO
            */
            $userDTO = $dto->userCreateDTO;

            //вызываем сервес для создание user
            /** @var User */
            $user = $this->userService->createUser($userDTO);

            /** @var OrganizationVO */
            $organizationVO = $dto->organizationVO;

            /** @var OrganizationCreateDTO */
            $organizationCreateDTO = OrganizationCreateDTO::make(
                organizationVO: $organizationVO,
                user: $user,
                type_cabinet: $dto->type_cabinet,
            );

            /** @var Organization */
            $org = $this->orgService->createOrganization($organizationCreateDTO);

            return [
                'user' => $user,
                'organization' => $org,
            ];

        });

        return $array;
    }
}
