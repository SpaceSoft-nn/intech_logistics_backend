<?php

namespace App\Modules\User\Domain\Actions\PersonalArea;

use App\Modules\User\Domain\Models\PersonalArea as Model;

class PersonalAreaCreateAction
{
    public static function make(string $uuid_owner) : Model
    {
        return (new self())->run($uuid_owner);
    }

    public function run(string $uuid_owner) : Model
    {
        $model = Model::query()
            ->create(
                [
                    'owner_id' => $uuid_owner,
                ],
            );

        return $model;
    }
}
