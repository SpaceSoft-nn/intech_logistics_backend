<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\Enums\UserRoleEnum;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Actions\PersonalArea\PersonalAreaCreateAction;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;
use Exception;

class UserCreateInteractor
{

    public function __construct(
        private UserRepository $repUser,
    ) { }

    private function createUser(UserCreateDTO $dto) : User
    {
        return $this->repUser->save($dto);
    }

    private function createPersonalArea(string $uuid_owner) : PersonalArea
    {
        return PersonalAreaCreateAction::make($uuid_owner);
    }

    private function createUserNotAdmin(UserCreateDTO $dto) : ?User
    {

        #TODO Проверить (ЛОГИКА НЕ РАБОТАЕТ НУЖНО СМОТРЕТЬ И ПЕРЕДЕЛЫВАТЬ - ЕСЛИ БУДЕТ ОТНОСИТСЯ К АДМИНУ)
        $userAuth = $dto->userAuth;
        $user = $this->createUser($dto);

        //устанавливаем к какому кабинету относится user
        $user->personal_area_id = $userAuth->personal_areas()->first(); #TODO с first могут быть проблемы

        //Сохраняем данные в бд.
        $user->save();

        return $user;
    }

    private function createUserIsAdmin(UserCreateDTO $dto) : ?User
    {
        #TODO Здесь нужно добавить цепочку обязаностей
        /**
        * @var User
        */
        $user = $this->createUser($dto);
        $area = $this->createPersonalArea($user->id);
        LinkUserToPersonalAreaAction::run($user, $area);

        return $user;
    }

    public function run(UserCreateDTO $dto) : ?User
    {
        switch ($dto->userVO->role) {

            case UserRoleEnum::admin:
            {
                return $this->createUserIsAdmin($dto);
                break;
            }

            case UserRoleEnum::manager:
            {
                return $this->createUserNotAdmin($dto);
                break;
            }

            case UserRoleEnum::observed:
            {
                return $this->createUserNotAdmin($dto);
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
