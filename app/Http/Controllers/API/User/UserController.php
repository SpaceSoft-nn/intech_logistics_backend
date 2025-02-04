<?php

namespace App\Http\Controllers\API\User;

use App\Modules\User\Domain\Models\User;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\User\App\Data\DTO\User\UserCreateDTO;
use App\Modules\User\Domain\Requests\UserCreateRequest;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\User\App\Data\DTO\User\ValueObject\UserVO;
use App\Modules\InteractorModules\Registration\App\Data\DTO\RegistrationDTO;
use App\Modules\InteractorModules\Registration\Domain\Model\UserOrganization;
use App\Modules\InteractorModules\Registration\Domain\Services\RegistrationService;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\User\Domain\Resources\UserHasOrganizationCollection;
use App\Modules\User\Domain\Resources\UserHasOrganizationResource;

use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class UserController
{

    public function index(
        GetTypeCabinetByOrganization $action,
        UserRepository $rep,

    ) {

        /** @var Organization */
        $organization = $action->getOrganizaion();

        /** @var Collection */
        $users = $rep->getUsersByOrganization($organization);

        return response()->json(array_success(UserHasOrganizationCollection::make($users), 'Return all user by organization.'), 200);
    }

    public function active(
        User $user,
        GetTypeCabinetByOrganization $action,
        AuthService $auth,
    ) {
        /** @var Organization */
        $organization = $action->getOrganizaion();

        /** @var User */
        $userAuth = isAuthorized($auth);

        {
            #TODO Временно даём только администратору изменить права активации user
            //проверяем что только админ может имзенить права
            abort_unless($organization->owner_id === $userAuth->id, 403, 'Недостаточно прав для выполнения этого действия.');

            $model = UserOrganization::where('user_id', $user->id)->where('organization_id', $organization->id)->first();

            abort_unless($model, 403, "Данный пользователь: {$user->id} не принадлежит к организации");

            abort_if($user->active, 404, 'Данный user - уже был активирован.');
        }

        //активируем user
        $user->active = true;
        $user->save();

        return response()->json(array_success(UserHasOrganizationResource::make($user), 'Данный user - был активирован в организации.'), 200);
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
