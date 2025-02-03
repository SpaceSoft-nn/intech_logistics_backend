<?php

namespace App\Modules\User\Domain\Interactor;

use Exception;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Actions\PersonalArea\PersonalAreaCreateAction;

class UserCreateInteractor
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

    private function createUserNotAdmin(UserVO $vo) : ?User
    {
        dd(1);
        #TODO Проверить (ЛОГИКА НЕ РАБОТАЕТ НУЖНО СМОТРЕТЬ И ПЕРЕДЕЛЫВАТЬ - ЕСЛИ БУДЕТ НЕ ОТНОСИТСЯ К АДМИНУ)
        // $userAuth = $dto->userAuth;
        // $user = $this->createUser($dto);

        // //устанавливаем к какому кабинету относится user
        // $user->personal_area_id = $userAuth->personal_areas()->first(); #TODO с first могут быть проблемы

        // //Сохраняем данные в бд.
        // $user->save();

        return $user;
    }

    private function createUserIsAdmin(UserVO $vo) : ?User
    {

        #TODO Здесь нужно добавить цепочку обязаностей
        /**
        * @var User
        */
        $user = $this->createUser($vo);

        dd($user);

        $area = $this->createPersonalArea($user->id);
        LinkUserToPersonalAreaAction::run($user, $area);

        return $user;
    }

    public function run(UserVO $vo) : ?User
    {

        switch ($vo->role) {

            case UserRoleEnum::admin:
            {
                return $this->createUserIsAdmin($vo);
                break;
            }

            case UserRoleEnum::manager:
            {
                return $this->createUserNotAdmin($vo);
                break;
            }

            case UserRoleEnum::observed:
            {
                return $this->createUserNotAdmin($vo);
                break;
            }

            default:
            {
                throw new Exception('Ошибка выбора role User в интеракторе, такой роли не существует.', 500);
                break;
            }

        }

    }


}
