<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\Domain\Actions\LinkUserToOrganizationAction;
use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Models\User;
use DB;

// Бизнес логика для создание заказа, когда заказ создатёся от Тендера
class UserManagerCreateInteractor
{
    public function __construct(
        private UserRepository $repUser,
    ) { }

    private function createUser(UserVO $vo) : User
    {
        return $this->repUser->save($vo);
    }


    public function execute(UserManagerCreateDTO $dto)
    {
        return $this->run($dto);
    }


    private function run(UserManagerCreateDTO $dto) : User
    {
        /** @var User */
        $user = DB::transaction(function () use ($dto) {


            #TODO Здесь нужно добавить цепочку обязаностей
            /**
            * @var User
            */
            $user = $this->createUser($dto->userVO);
            LinkUserToPersonalAreaAction::run($user, $dto->personalArea);
            LinkUserToOrganizationAction::run(LinkUserToOrganizationDTO::make(
                user: $user,
                organization: $dto->organization,
                type_cabinet: $dto->type_cabinet,
            ));

            return $user;
            
        });

        return $user;
    }

}
