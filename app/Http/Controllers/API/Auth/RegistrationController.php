<?php

namespace App\Http\Controllers\API\Auth;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Requests\UserRegistrationRequest;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\User\Domain\Models\User;
use App\Modules\User\Domain\Resources\UserResource;

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

        $token = $auth->loginUser($model);

        return response()->json( array_success($token, 'Successfully registration'), 201);
    }
}
