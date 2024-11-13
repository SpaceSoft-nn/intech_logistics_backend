<?php

namespace App\Http\Controllers\API\Organization;

use App\Modules\Auth\Domain\Interface\AuthServiceInterface;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\Organization\Domain\Requests\CreateOrganizationRequest;
use App\Modules\Organization\Domain\Resources\OrganizationResource;
use App\Modules\Organization\Domain\Services\OrganizationService;
use App\Modules\User\Domain\Models\User;

use function App\Helpers\array_error;
use function App\Helpers\array_success;
use function App\Helpers\isAuthorized;

class OrganizationController
{
    public function __construct(
        private OrganizationService $service,
        private AuthServiceInterface $auth,
    ) {}

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

    /**
     * Связываем user с organization
     * @return [type]
     */
    public function linkUserToOrg()
    {

    }

}
