<?php

namespace App\Http\Controllers\API\User;

use App\Modules\User\Domain\Models\User;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\Domain\Requests\UserCreateRequest;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Resources\UserHasOrganizationCollection;

use function App\Helpers\array_success;

class UserController
{

    public function index(
        GetTypeCabinetByOrganization $action,
        UserRepository $rep,
    ) {

        /** @var array */
        $array = $action->isCustomer();

        /** @var Organization */
        $organization = $array['organization'];

        /** @var Collection */
        $users = $rep->getUsersByOrganization($organization);

        return response()->json(array_success(UserHasOrganizationCollection::make($users), 'Return all user by organization.'), 200);
    }

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
            UserCreateDTO::make($userVO),
            phone: $request->input('phone') ?? null,
            email: $request->input('email') ?? null,
        ));

        #TODO возвращать объект
        dd('Это бАГ! ВАНЯ НАПИШИ МНЕ ДОДЕЛАТЬ ЕСЛИ УВИДИШЬ ЭТО');
    }

}
