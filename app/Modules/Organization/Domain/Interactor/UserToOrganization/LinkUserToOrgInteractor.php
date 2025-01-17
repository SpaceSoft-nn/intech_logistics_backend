<?php

namespace App\Modules\Organization\Domain\Interactor\UserToOrganization;

use App\Modules\Organization\App\Data\DTO\Base\BaseDTO;
use App\Modules\Organization\App\Data\DTO\OrganizationCreateDTO;
use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\Domain\Actions\LinkUserToOrganizationAction;
use App\Modules\Organization\Domain\Interface\Repositories\IRepository;
use App\Modules\Organization\Domain\Models\Organization;
use Exception;

class LinkUserToOrgInteractor
{

    /**
     * @param OrganizationCreateDTO $dto
     *
     * @return
     */
    public static function run(BaseDTO $dto) : Organization
    {
        /** @var OrganizationVO */
        $organizationVO = $dto->organizationVO->addOwner($dto->user->id);

        //Создаём организацию (привязываем IRepository в provider)
        $organization = app(IRepository::class)->save($organizationVO);

        //Привязываем к user
        $status = LinkUserToOrganizationAction::run(LinkUserToOrganizationDTO::make($dto->user, $organization, $dto->type_cabinet));

        if(!$status) { throw new Exception('Критическая ошибка создание user в интеракторе', 500); }

        return $organization;
    }
}
