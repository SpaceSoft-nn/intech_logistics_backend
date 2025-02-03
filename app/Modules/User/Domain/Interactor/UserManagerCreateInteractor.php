<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\Base\Error\BusinessException;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Services\UserService;

// Бизнес логика для создание заказа, когда заказ создатёся от Тендера
class UserManagerCreateInteractor
{

    public function __construct(
        private OrganizationRepository $orgRep,
        private UserRepository $userRep,
        private UserService $userService,
    ) { }


    public function execute(UserManagerCreateDTO $dto)
    {
        return $this->run($dto);
    }


    private function run(UserManagerCreateDTO $dto)
    {
        /** @var Organization */
        $organization = $dto->organization;

        /** @var User */
        $owner = User::find($organization->owner_id);

        $personal_area = $this->userRep->isOwnerPersonalArea($owner);

        dd($personal_area);

    }

    private function findOrganization(string $organization_id) : Organization
    {
        $org = $this->orgRep->getById($organization_id);
        if(is_null($org)) { throw new BusinessException('Organization not found', 404); }

        return $org;
    }

}
