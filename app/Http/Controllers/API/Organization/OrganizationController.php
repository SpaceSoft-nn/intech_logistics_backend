<?php

namespace App\Http\Controllers\API\Organization;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\IndividualPeople\Domain\Models\DriverPeople;
use App\Modules\IndividualPeople\Domain\Resources\TypePeople\DriverPeopleCollection;
use App\Modules\OrderUnit\Domain\Models\OrderUnit;
use App\Modules\OrderUnit\Domain\Resources\OrderUnit\OrderUnitCollection;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Requests\CreateOrganizationRequest;
use App\Modules\Organization\Domain\Resources\OrganizationCollection;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\Transport\Domain\Resources\TransportCollection;
use App\Modules\User\Domain\Models\User;
use Request;
use Symfony\Component\Mailer\Transport\Transports;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationController
{
    public function __construct(
        private OrganizationService $service,
        private AuthServiceInterface $auth,
    ) {}

    //Вернуть все транспортные средства связанные с Organization
    public function transports(Organization $organization)
    {
        /** @var Transports */
        $model = $organization->transports;

        return response()->json(array_success(TransportCollection::make($model), 'Return all transport by organization.'), 200);
    }

    //Вернуть всех водителей связанных с Organization
    public function drivers(Organization $organization)
    {
        /** @var DriverPeople */
        $model = $organization->drivers;

        return response()->json(array_success(DriverPeopleCollection::make($model), 'Return all driver by organization.'), 200);
    }

    //Вернуть все заказы связанные с Organization
    public function orders(Organization $organization)
    {
        /** @var OrderUnit */
        $model = $organization->order_units;

        return response()->json(array_success(OrderUnitCollection::make($model), 'Return all orders by organization.'), 200);
    }

    //TODO Временно возвращаем все организации (потом убрать (проверку через user сделать) )
    public function index()
    {
        return response()->json(array_success(OrganizationCollection::make(Organization::all()), 'Return organization select.'), 200);
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


}
