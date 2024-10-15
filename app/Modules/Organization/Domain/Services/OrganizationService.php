<?php

namespace App\Modules\Organization\Domain\Services;

use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\App\Repositories\OrganizationRepository;
use App\Modules\Organization\Domain\Actions\LinkUserToOrganizationAction;
use App\Modules\Organization\Domain\Interactor\UserToOrganization\LinkUserToOrgInteractor;
use App\Modules\Organization\Domain\Models\Organization;

class OrganizationService
{
    public function __construct(
        public OrganizationRepository $rep,
    ) {}

    /**
    * @param OrganizationCreateDTO $dto
    *
    * @return Organization
    */
    public function createOrganization(BaseDTO $dto) : Organization
    {
        return LinkUserToOrgInteractor::run($dto);
    }

    public function getOrganization(string $uuid) : ?Organization
    {
        return $this->rep->getById($uuid);
    }

    /**
     * Привязываем User к Organization через связь многие:многим
     * @param LinkUserToOrganizationDTO $dto
     *
     * @return bool
    */
    public function linkOrganizationToUser(LinkUserToOrganizationDTO $dto) : bool
    {
        return LinkUserToOrganizationAction::run($dto);
    }
}
