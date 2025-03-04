<?php

namespace App\Http\Controllers\API\Organization;

use function App\Helpers\array_error;
use function App\Helpers\isAuthorized;
use function App\Helpers\array_success;
use App\Modules\User\Domain\Models\User;
use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\User\App\Repositories\UserRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Base\Actions\GetTypeCabinetByOrganization;
use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\User\Domain\Resources\UserHasOrganizationResource;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\User\Domain\Resources\UserHasOrganizationCollection;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Resources\OrganizationCollection;
use App\Modules\Organization\Domain\Requests\CreateOrganizationRequest;

use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitCollection;
use App\Modules\InteractorModules\Registration\Domain\Model\UserOrganization;

class OrganizationController
{
    public function __construct(
        private OrganizationService $service,
        private AuthServiceInterface $auth,
    ) {}


    //Вернуть все заказы связанные с Organization
    public function orders(Organization $organization)
    {
        /** @var OrderUnit */
        $model = $organization->order_units;

        return response()->json(array_success(OrderUnitCollection::make($model), 'Return all orders by organization.'), 200);
    }

    //TODO Временно возвращаем все организации (потом убрать (проверку через user сделать) )
    public function index(
        AuthService $auth,
    ) {

        /** @var User */
        $user = isAuthorized($auth);

        return response()->json(array_success(OrganizationCollection::make($user->organizations), 'Return organization select.'), 200);
    }

    public function show(Organization $organization)
    {
        return response()->json(array_success(OrganizationResource::make($organization), 'Return organization select.'), 200);
    }


    public function create(CreateOrganizationRequest $request)
    {
        /**
        * @var OrganizationVO
        */
        $orgVO = $request->getValueObject();

        #TODO - Может быть так что организацию мы можем создавать без User (например с внешнего апи) - предусмотреть это в будущем
        /**
        * @var User
        */
        $user = isAuthorized($this->auth);

        //Устанавливаем user к organization
        $orgVO->addOwner($user->id);

        //TODO Будет двойная валидация если вызвать $request->getTypeCabinet(), исправить
        $organization = $this->service->createOrganization(
            OrganizationCreateDTO::make($orgVO, $user, $request->getTypeCabinet())
        );


        return $organization ?
            response()->json(array_success(OrganizationResource::make($organization), 'Create organization.'), 201)
        :
            response()->json(array_error(OrganizationResource::make($organization), 'Faild create organization.'), 400);
    }

    //вернуть всех user - которые принадлежат организации
    public function indexUsers(
        GetTypeCabinetByOrganization $action,
        UserRepository $rep,

    ) {

        /** @var Organization */
        $organization = $action->getOrganizaion();

        /** @var Collection */
        $users = $rep->getUsersByOrganization($organization);

        return response()->json(array_success(UserHasOrganizationCollection::make($users), 'Return all user by organization.'), 200);
    }

    //активировать user в организации
    public function activeUsers(
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


}
