<?php

namespace App\Modules\User\Domain\Actions;

use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class LinkUserToPersonalAreaAction
{
    public static function run(User $user, PersonalArea $personalArea) : bool
    {
        try {

            $user->personal_areas()->syncWithoutDetaching([$personalArea->id]);
            $user->save();
            return true;

        } catch (\Throwable $th) {
            
            return false;

        }

    }
}
