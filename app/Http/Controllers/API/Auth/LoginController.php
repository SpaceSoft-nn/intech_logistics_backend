<?php

namespace App\Http\Controllers\API\Auth;

use App\Modules\Auth\App\Data\DTO\UserAttemptDTO;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Notification\Domain\Models\EmailList;
use App\Modules\Notification\Domain\Models\PhoneList;
use App\Modules\User\Domain\Requests\UserLoginRequest;
use Auth;

use function App\Helpers\array_error;
use function App\Helpers\array_success;

class LoginController
{
    public function __invoke(
        UserLoginRequest $request,
        AuthService $auth,
    ) {
        $validated = $request->validated();

        $json_token = $auth->attemptUserAuth(
            UserAttemptDTO::make(
                email: $validated['email'] ?? null,
                phone: $validated['phone'] ?? null,
                password: $validated['password'],
            )
        );


        return $json_token ?
            response()->json(array_success($json_token, 'Successfully login.'), 200)
        :
            response()->json(array_error(null, 'Неверный телефон/почта или пароль..'), 400);

    }


}
