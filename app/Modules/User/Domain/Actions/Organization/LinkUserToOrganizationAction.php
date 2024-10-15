<?php

namespace App\Modules\User\Domain\Actions\Organization;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;
use Exception;

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

        try
        {

            //Сохраняем связь от user к personal area
            $dto->user->organizations()->syncWithoutDetaching([ $dto->organization->id => ['type_cabinet' => $dto->type_cabinet] ]);
            return true;

        } catch (\Throwable $th) {

            Mylog("Ошибка в LinkUserToOrganizationAction . $th");
            throw new Exception('Ошибка в LinkUserToOrganizationAction', 500);

        }

    }
}
