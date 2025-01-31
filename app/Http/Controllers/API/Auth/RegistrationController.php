<?php

namespace App\Http\Controllers\API\Auth;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Base\Error\BusinessException;
use App\Modules\InteractorModules\Registration\App\Data\DTO\CreateRegisterAllDTO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Requests\RegistrationUserAndOrganizationRequest;
use App\Modules\InteractorModules\Registration\Domain\Requests\UserRegistrationRequest;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Resources\UserResource;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class RegistrationController
{
    //старая реализация где создаётся только Пользователь User
    public function store1(
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
                    $phoneModel = $model->phone()->create(['value' => $validated['phone'], 'status' => true]);
                    $model->phone_id = $phoneModel->id;
                    $model->save();

                } else {

                    $emailModel = $model->email()->create(['value' => $validated['email'], 'status' => true]);
                    $model->email_id = $emailModel->id;
                    $model->save();
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

    public function store(
        RegistrationUserAndOrganizationRequest $request,
        RegistrationService $registerService,
        AuthService $auth,
    ) {

        //Регистрация пользователя + создание организации

        /** @var CreateRegisterAllDTO */
        $createRegisterAllDTO = $request->createRegisterAllDTO();

        /** @var array */
        $array = $registerService->registerUserAll($createRegisterAllDTO);

        $token = $auth->loginUser($array['user']);

        return $token && $array ?
            response()->json( array_success([
                'token' => $token,
                'organization' => OrganizationResource::make($array['organization']),
                'user' => UserResource::make($array['user']),
            ], 'Successfully registration.'), 201)
                :
            response()->json( array_error( null, 'Error receiving token.'), 401);

    }
}
