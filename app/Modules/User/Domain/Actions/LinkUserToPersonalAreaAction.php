<?php

namespace App\Modules\User\Domain\Actions;

use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;

class LinkUserToPersonalAreaAction
{
    public static function run(User $user, PersonalArea $personalArea) : bool
    {
        $user->personal_areas()->attach($personalArea->id);

        return true;
    }
}
