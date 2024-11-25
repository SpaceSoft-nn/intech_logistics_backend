<?php

namespace App\Http\Controllers\API\Auth;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Requests\UserRegistrationRequest;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class RegistrationController
{
    public function __invoke(
        UserRegistrationRequest $request,
        RegistrationService $registerService,
        AuthService $auth,
    ) {

        $validated = $request->validated();
        /**
        * @var UserVO
        */
        $userVO = $request->getValueObject();


        //#TODO изменить логику (RegistrationDTO вынести сразу в request для создание)

        /**
        * @var User|array
        */
        $model = $registerService->registerUser(RegistrationDTO::make(
            UserCreateDTO::make($userVO),
            phone: $validated['phone'] ?? null,
            email: $validated['email'] ?? null,
        ));

        //Возвращаем информацию об ошибки нотификации P.S Переделать на глобальный обработчик
        if(is_array($model)) { return array_error(message: $model['message']); }


        { #TODO Временно отключена в сервесе нотификация по телефону и email, сделан быстрый код для регистрации (потом убрать)
            try {


                if(isset($validated['phone']))
                {
                    $model->phone()->create(['value' => $validated['phone'], 'status' => true]);
                } else {
                    $model->email()->create(['value' => $validated['email'], 'status' => true]);
                }

            } catch (\Throwable $th) {

                if(isset($validated['phone'])) {
                    throw new BusinessException('Пользователь с такими данными phone уже существует.', 409);
                } else {
                    throw new BusinessException('Пользователь с такими данными email уже существует.', 409);
                }

            }

        }

        $token = $auth->loginUser($model);

        return $token ?
            response()->json( array_success($token, 'Successfully registration.'), 201)
            :
            response()->json( array_error( null, 'Error receiving token.'), 401);
    }
}
