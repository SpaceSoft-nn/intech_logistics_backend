<?php

namespace App\Modules\User\Domain\Interactor;

use App\Modules\User\App\Data\DTO\User\UserManagerCreateDTO;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;

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


    private function run(UserManagerCreateDTO $dto)
    {

        dd(1);

    }

}
