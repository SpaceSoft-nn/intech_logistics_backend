<?php

namespace App\Http\Controllers\API\User;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Requests\UserCreateRequest;

class UserController
{

    public function create(
        UserCreateRequest $request,
        RegistrationService $registerService,
        AuthService $auth,
    ) {
        /**
        * @var UserVO
        */
        $userVO = $request->getValueObject();

        /**
        * @var User
        */
        $user = $auth->getUserAuth();

        //TODO Перенести потом в репозиторий
        $model = $user->query()
        ->with(['personal_areas' => function($query) use ($user) {
            $query->where('owner_id', $user->id);
        }])
        ->find($user->id)
        ->personal_areas->first();

        //TODO Нужно потом доделать регистрацию при manager и observed в интеракторе
        /**
        *  $userVO->setPersonalArea - устанавливсем значение area_id
        * @var User|array
        */
        $model = $registerService->registerUser(RegistrationDTO::make(
            UserCreateDTO::make($userVO->setPersonalArea($model->id)),
            phone: $request->input('phone') ?? null,
            email: $request->input('email') ?? null,
        ));

        #TODO возвращать объект
        dd('Это бАГ! ВАНЯ НАПИШИ МНЕ ДОДЕЛАТЬ ЕСЛИ УВИДИШЬ ЭТО');
    }

}
