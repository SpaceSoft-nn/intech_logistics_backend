<?php

namespace App\Modules\User\Domain\Interactor;

use Exception;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Actions\PersonalArea\PersonalAreaCreateAction;
use DB;

class UserAdminCreateInteractor
{

    public function __construct(
        private UserRepository $repUser,
    ) { }

    private function createUser(UserVO $vo) : User
    {
        return $this->repUser->save($vo);
    }

    private function createPersonalArea(string $uuid_owner) : PersonalArea
    {
        return PersonalAreaCreateAction::make($uuid_owner);
    }


    private function createUserIsAdmin(UserVO $vo) : ?User
    {

        /** @var User */
        $user = DB::transaction(function () use ($vo) {

           #TODO Здесь нужно добавить цепочку обязаностей
            /**
            * @var User
            */
            $user = $this->createUser($vo);

            $area = $this->createPersonalArea($user->id);
            LinkUserToPersonalAreaAction::run($user, $area);

            return $user;
        });

        return $user;
    }

    public function execute(UserVO $vo) : ?User
    {
        return $this->run($vo);
    }

    private function run(UserVO $vo) : ?User
    {
        return $this->createUserIsAdmin($vo);
    }


}
