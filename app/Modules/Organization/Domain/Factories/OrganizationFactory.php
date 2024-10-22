<?php

namespace App\Modules\Organization\Domain\Factories;

use App\Modules\Organization\App\Data\DTO\User\LinkUserToOrganizationDTO;
use App\Modules\Organization\App\Data\DTO\ValueObject\OrganizationVO;
use App\Modules\Organization\App\Data\Enums\OrganizationEnum;
use App\Modules\Organization\App\Data\Enums\TypeCabinetEnum;
use App\Modules\Organization\Domain\Actions\LinkUserToOrganizationAction;
use App\Modules\Organization\Domain\Models\Organization;
use App\Modules\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    protected $model = Organization::class;

    public function definition(): array
    {

        /**
        * @var User
        */
        $user = User::factory()->create();

        #TODO Соединение с таблице через связь многие ко многим нету.

        /**
        * @var OrganizationVO
        */
        $organizationVO = OrganizationVO::make(
            owner_id : $user->id,
            name : $this->faker->name(),
            address : $this->faker->address() ,
            website : $this->faker->url() ,
            description : $this->faker->sentence() ,
            industry : $this->faker->word() ,
            founded_date : $this->faker->date() ,
            phone : $this->faker->phoneNumber() ,
            email : $this->faker->safeEmail() ,
            remuved : null ,
            type : OrganizationEnum::ooo,
            inn : $this->faker->unique()->numerify('##########'),
            kpp : $this->faker->unique()->numerify('#########') ,
            registration_number : $this->faker->unique()->numerify('############') ,
            registration_number_individual : null ,
        );

        return $organizationVO->toArrayNotNull();
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Organization $organization) {
            // ...
        })->afterCreating(function (Organization $organization) {

            //нужна ли эта логика тут?
            // $user = User::find($organization->owner_id);
            // //Связываем при связи многие ко многим через промежуточную таблицу
            // LinkUserToOrganizationAction::run(LinkUserToOrganizationDTO::make($user, $organization, TypeCabinetEnum::customer));


        });
    }

}
