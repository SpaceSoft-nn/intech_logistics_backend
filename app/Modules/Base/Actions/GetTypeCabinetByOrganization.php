<?php

namespace App\Modules\Base\Actions;

use App\Modules\Auth\Domain\Services\AuthService;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;

use function App\Helpers\isAuthorized;

class GetTypeCabinetByOrganization
{

    public function __construct(
        private OrganizationRepository $repOrg,
        private AuthService $auth,
    ) { }

    public function isCustomer() : array
    {

        /** @var User */
        $user = isAuthorized($this->auth);

        //ЭТОТ КОСТЫЛЬ МЕНЯ ЗАСТАВИЛ ДЕЛАТЬ ФРОТЕНДЕР! ВОТ ЕГО ГИТ https://github.com/Zeltharion
        $organization_id = request()->header('organization_id');

        $organization = Organization::find($organization_id);

        abort_unless( $organization, 404, 'Организации не существует');

        /** @var TypeCabinetEnum */
        $typeCabinet = $this->repOrg->getTypeCabinet($user, $organization);

        /** @var bool */
        return [
            'status' => TypeCabinetEnum::isCustomer($typeCabinet),
            'organization' => $organization,
        ];
    }
}
