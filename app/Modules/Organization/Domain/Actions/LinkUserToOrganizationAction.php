<?php

namespace App\Modules\Organization\Domain\Actions;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

use function App\Helpers\Mylog;

class LinkUserToOrganizationAction
{
    /**
     * Указываем связи через промежуточную таблицу
     * @param User $user
     * @param PersonalArea $personalArea
     *
     * @return bool
     */
    public static function run(LinkUserToOrganizationDTO $dto) : bool
    {


        try {

            /**
            * @var User
            */
            $user = $dto->user;

            /**
            * @var Organization
            */
            $organization = $dto->organization;

            //Проверем существует ли запись с таким type_cabinet + user_id и organization_id
            $status = $dto->user->organizations()
                ->wherePivot('organization_id', $organization->id)
                ->wherePivot('type_cabinet', $dto->type_cabinet)
                ->exists();

            if (!$status)
            {
                $user->organizations()->attach($organization->id, ['type_cabinet' => $dto->type_cabinet]);
            }

            return true;

        } catch (\Throwable $th) {

            Mylog('Ошибка при LinkUserToOrganizationAction');
            return false;

        }

    }
}
