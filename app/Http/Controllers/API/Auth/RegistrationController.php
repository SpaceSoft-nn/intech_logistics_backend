<?php

namespace App\Http\Controllers\API\Auth;

use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\Organization\Domain\Requests\UserRegistrationRequest;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;

class RegistrationController
{
    public function __invoke(
        UserRegistrationRequest $request,
        RegistrationService $registerService,
    ) {
        /**
        * @var UserVO
        */
        $userVO = $request->getValueObject();

        dd($userVO);

        // RegistrationDTO

        // $status = $registerService->registerUser();

    }
}
