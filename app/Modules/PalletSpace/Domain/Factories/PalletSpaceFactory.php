<?php

namespace App\Modules\PalletSpace\Domain\Factories;

use App\Modules\PalletSpace\App\Data\DTO\ValueObject\PalletSpaceVO;
use App\Modules\PalletSpace\App\Data\Enums\TypeMaterialPalletSpaceEnum;
use App\Modules\PalletSpace\App\Data\Enums\TypeSizePalletSpaceEnum;
use App\Modules\PalletSpace\Domain\Models\PalletSpace;
use Illuminate\Database\Eloquent\Factories\Factory;

class PalletSpaceFactory extends Factory
{
    protected $model = PalletSpace::class;

    public function definition(): array
    {

        /**
        * @var PalletSpaceVO
        */
        $palletSpaceVO = PalletSpaceVO::make(
            type_material: TypeMaterialPalletSpaceEnum::wood,
            type_size: TypeSizePalletSpaceEnum::eur,
            size: $this->faker->numberBetween(2,5),
            witght: 12,
            max_witght: 800,
            uuid_out: $this->faker->uuid(),
            manufacture: "ООО 'ТараШрек' ",
            description: $this->faker->text(),
        );

        return $palletSpaceVO->toArrayNotNull();
    }

}
