<?php

namespace App\Modules\User\Domain\Actions;

use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class LinkUserToPersonalAreaAction
{
    /**
     * Нам нужно сохранять связь многие ко многим таким способом (что бы laravel связи работали)
     * @param User $user
     * @param PersonalArea $personalArea
     *
     * @return bool
     */
    public static function run(User $user, PersonalArea $personalArea) : bool
    {
        try {

            //Сохраняем связь от user к personal area
            $user->personal_areas()->syncWithoutDetaching([$personalArea->id]);

            return true;

        } catch (\Throwable $th) {

            return false;

        }

    }
}
