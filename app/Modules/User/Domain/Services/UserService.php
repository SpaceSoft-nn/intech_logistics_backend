<?php

namespace App\Modules\User\Domain\Services;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\Domain\Actions\LinkUserToOrganizationAction;
use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Interactor\UserCreateInteractor;
use App\Modules\User\Domain\Interactor\UserManagerCreateInteractor;
use App\Modules\User\Domain\Interface\Service\IUserService;
use App\Modules\User\Domain\Models\User;

class UserService implements IUserService
{
    public function __construct(
        public UserRepository $rep,
        public UserCreateInteractor $interactor,

    ) {}

    /**
     * @param UserVO $vo
     *
     * @return User
     */
    public function createUser(UserVO $vo) : User
    {
        return $this->interactor->run($vo);
    }

    public function getUser(string $uuid) : ?User
    {
        return $this->rep->getById($uuid);
    }

     /**
     * Привязываем User к Organization через связь многие:многим
     * @param LinkUserToOrganizationDTO $dto
     *
     * @return bool
    */
    public function linkUserToOrganization(LinkUserToOrganizationDTO $dto) : bool
    {
        return LinkUserToOrganizationAction::run($dto);
    }

}
