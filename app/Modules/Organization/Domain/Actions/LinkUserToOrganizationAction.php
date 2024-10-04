<?php

namespace App\Modules\Organization\Domain\Actions;

use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class LinkUserToOrganizationAction
{
    /**
     * Указываем связи через промежуточную таблицу
     * @param User $user
     * @param PersonalArea $personalArea
     *
     * @return bool
     */
    public static function run(User $user, Organization $organization) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $user->personal_areas()->syncWithoutDetaching([$organization->id]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
