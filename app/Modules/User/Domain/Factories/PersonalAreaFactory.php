<?php

namespace App\Modules\User\Domain\Factories;

use App\Modules\User\Domain\Actions\LinkUserToPersonalAreaAction;
use App\Modules\User\Domain\Actions\PersonalArea\PersonalAreaCreateAction;
use App\Modules\User\Domain\Models\PersonalArea;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Model>
 */
class PersonalAreaFactory extends Factory
{
    protected $model = PersonalArea::class;


    public function definition(): array
    {
        /**
        * @var User
        */
        $user = User::factory()->create();

        return [
            'owner_id' => $user->id,
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (PersonalArea $personalArea) {
            // ...
        })->afterCreating(function (PersonalArea $personalArea) {
            
            $user = User::find($personalArea->owner_id);
            LinkUserToPersonalAreaAction::run($user, $personalArea);

        });
    }
}
